<?php

namespace Ds\Component\Config\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Ds\Component\Container\Attribute;
use Ds\Component\Encryption\Service\CipherService;
use Ramsey\Uuid\Uuid;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

/**
 * Class Version0_15_0
 *
 * @package Ds\Component\Config
 */
final class Version0_15_0 extends AbstractMigration implements ContainerAwareInterface
{
    use Attribute\Container;

    /**
     * Up migration
     *
     * @param \Doctrine\DBAL\Schema\Schema $schema
     * @param array $configs
     */
    public function up(Schema $schema, array $configs = [])
    {
        $cipherService = $this->container->get(CipherService::class);
        $encrypted = ['ds_api.user.password'];
        $sequences['ds_config_id_seq'] = 1 + count($configs);

        switch ($this->platform->getName()) {
            case 'postgresql':
                $this->addSql('CREATE SEQUENCE ds_config_id_seq INCREMENT BY 1 MINVALUE 1 START '.$sequences['ds_config_id_seq']);
                $this->addSql('CREATE TABLE ds_config (id INT NOT NULL, uuid UUID NOT NULL, "owner" VARCHAR(255) DEFAULT NULL, owner_uuid UUID DEFAULT NULL, "key" VARCHAR(255) NOT NULL, value TEXT DEFAULT NULL, version INT DEFAULT 1 NOT NULL, tenant UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
                $this->addSql('CREATE UNIQUE INDEX UNIQ_758C45F4D17F50A6 ON ds_config (uuid)');
                $this->addSql('CREATE UNIQUE INDEX UNIQ_758C45F48A90ABA94E59C462 ON ds_config (key, tenant)');

                $i = 0;

                foreach ($configs as $config) {
                    if (null === $config->uuid) {
                        $config->uuid = Uuid::uuid4()->toString();
                    }

                    $config->value = serialize($config->value);

                    if (in_array($config->key, $encrypted)) {
                        $config->value = $cipherService->encrypt($config->value);
                    }

                    $this->addSql(sprintf(
                        'INSERT INTO ds_config (id, uuid, owner, owner_uuid, key, value, version, tenant, created_at, updated_at) VALUES (%d, %s, %s, %s, %s, %s, %d, %s, %s, %s);',
                        ++$i,
                        $this->connection->quote($config->uuid),
                        $this->connection->quote($config->owner),
                        $this->connection->quote($config->owner_uuid),
                        $this->connection->quote($config->key),
                        $this->connection->quote($config->value),
                        $config->version,
                        $this->connection->quote($config->tenant),
                        'now()',
                        'now()'
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
                $this->addSql('DROP SEQUENCE ds_config_id_seq CASCADE');
                $this->addSql('DROP TABLE ds_config');
                break;

            default:
                $this->abortIf(true,'Migration cannot be executed on "'.$this->platform->getName().'".');
                break;
        }
    }
}
