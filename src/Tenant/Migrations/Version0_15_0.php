<?php

namespace Ds\Component\Tenant\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Ramsey\Uuid\Uuid;

/**
 * Class Version0_15_0
 */
final class Version0_15_0 extends AbstractMigration
{
    /**
     * Up migration
     *
     * @param \Doctrine\DBAL\Schema\Schema $schema
     * @param array $tenants
     */
    public function up(Schema $schema, array $tenants = [])
    {
        $tenantSequence = 1 + count($tenants);

        switch ($this->platform->getName()) {
            case 'postgresql':
                $this->addSql('CREATE SEQUENCE ds_tenant_id_seq INCREMENT BY 1 MINVALUE 1 START '.$tenantSequence);
                $this->addSql('CREATE TABLE ds_tenant (id INT NOT NULL, uuid UUID NOT NULL, version INT DEFAULT 1 NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
                $this->addSql('CREATE UNIQUE INDEX UNIQ_EF5FAEEAD17F50A6 ON ds_tenant (uuid)');

                $i = 0;

                foreach ($tenants as $tenant) {
                    if (null === $tenant->uuid) {
                        $tenant->uuid = Uuid::uuid4()->toString();
                    }

                    $this->addSql(sprintf(
                        'INSERT INTO ds_tenant (id, uuid, created_at, updated_at) VALUES (%d, %s, %s, %s);',
                        ++$i,
                        $this->connection->quote($tenant->uuid),
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
                $this->addSql('DROP SEQUENCE ds_tenant_id_seq CASCADE');
                $this->addSql('DROP TABLE ds_tenant');
                break;

            default:
                $this->abortIf(true,'Migration cannot be executed on "'.$this->platform->getName().'".');
                break;
        }
    }
}
