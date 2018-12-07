<?php

namespace Ds\Component\Parameter\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Ds\Component\Container\Attribute;
use Ds\Component\Encryption\Service\CipherService;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

/**
 * Class Version0_15_0
 *
 * @package Ds\Component\Parameter
 */
final class Version0_15_0 extends AbstractMigration implements ContainerAwareInterface
{
    use Attribute\Container;

    /**
     * Up migration
     *
     * @param \Doctrine\DBAL\Schema\Schema $schema
     * @param array $parameters
     */
    public function up(Schema $schema, array $parameters = [])
    {
        $cipherService = $this->container->get(CipherService::class);
        $encrypted = ['ds_system.user.password'];
        $sequences['ds_parameter_id_seq'] = 1 + count($parameters);

        switch ($this->platform->getName()) {
            case 'postgresql':
                $this->addSql('CREATE SEQUENCE ds_parameter_id_seq INCREMENT BY 1 MINVALUE 1 START '.$sequences['ds_parameter_id_seq']);
                $this->addSql('CREATE TABLE ds_parameter (id INT NOT NULL, "key" VARCHAR(255) NOT NULL, value TEXT DEFAULT NULL, PRIMARY KEY(id))');
                $this->addSql('CREATE UNIQUE INDEX UNIQ_B3C0FD91F48571EB ON ds_parameter ("key")');

                $i = 0;

                foreach ($parameters as $parameter) {
                    $parameter->value = serialize($parameter->value);

                    if (in_array($parameter->key, $encrypted)) {
                        $parameter->value = $cipherService->encrypt($parameter->value);
                    }

                    $this->addSql(sprintf(
                        'INSERT INTO ds_parameter (id, key, value) VALUES (%d, %s, %s);',
                        ++$i,
                        $this->connection->quote($parameter->key),
                        $this->connection->quote($parameter->value)
                    ));
                }

                break;

            default:
                $this->abortIf(true,'Migration cannot be executed on "'.$this->platform->getName().'".');
                break;
        }
    }

    /**
     * Down migration
     *
     * @param \Doctrine\DBAL\Schema\Schema $schema
     */
    public function down(Schema $schema)
    {
        switch ($this->platform->getName()) {
            case 'postgresql':
                $this->addSql('DROP SEQUENCE ds_parameter_id_seq CASCADE');
                $this->addSql('DROP TABLE ds_parameter');
                break;

            default:
                $this->abortIf(true,'Migration cannot be executed on "'.$this->platform->getName().'".');
                break;
        }
    }
}
