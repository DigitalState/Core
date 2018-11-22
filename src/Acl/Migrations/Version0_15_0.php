<?php

namespace Ds\Component\Acl\Migrations;

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
     * @param array $accesses
     */
    public function up(Schema $schema, array $accesses = [])
    {
        $sequences['ds_access_id_seq'] = 1 + count($accesses);
        $sequences['ds_access_permission_id_seq'] = 1;

        foreach ($accesses as $access) {
            $sequences['ds_access_permission_id_seq'] += count($access->permissions);
        }

        switch ($this->platform->getName()) {
            case 'postgresql':
                $this->addSql('CREATE SEQUENCE ds_access_id_seq INCREMENT BY 1 MINVALUE 1 START '.$sequences['ds_access_id_seq']);
                $this->addSql('CREATE SEQUENCE ds_access_permission_id_seq INCREMENT BY 1 MINVALUE 1 START '.$sequences['ds_access_permission_id_seq']);
                $this->addSql('CREATE TABLE ds_access (id INT NOT NULL, uuid UUID NOT NULL, "owner" VARCHAR(255) DEFAULT NULL, owner_uuid UUID DEFAULT NULL, assignee VARCHAR(255) DEFAULT NULL, assignee_uuid UUID DEFAULT NULL, version INT DEFAULT 1 NOT NULL, tenant UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
                $this->addSql('CREATE UNIQUE INDEX UNIQ_A76F41DCD17F50A6 ON ds_access (uuid)');
                $this->addSql('CREATE TABLE ds_access_permission (id INT NOT NULL, access_id INT DEFAULT NULL, scope VARCHAR(255) DEFAULT NULL, entity VARCHAR(255) DEFAULT NULL, entity_uuid UUID DEFAULT NULL, "key" VARCHAR(255) NOT NULL, attributes JSON NOT NULL, tenant UUID NOT NULL, PRIMARY KEY(id))');
                $this->addSql('CREATE INDEX IDX_D46DD4D04FEA67CF ON ds_access_permission (access_id)');
                $this->addSql('COMMENT ON COLUMN ds_access_permission.attributes IS \'(DC2Type:json_array)\'');
                $this->addSql('ALTER TABLE ds_access_permission ADD CONSTRAINT FK_D46DD4D04FEA67CF FOREIGN KEY (access_id) REFERENCES ds_access (id) NOT DEFERRABLE INITIALLY IMMEDIATE');

                $i = 0;
                $j = 0;

                foreach ($accesses as $access) {
                    if (null === $access->uuid) {
                        $access->uuid = Uuid::uuid4()->toString();
                    }

                    $this->addSql(sprintf(
                        'INSERT INTO ds_access (id, uuid, owner, owner_uuid, assignee, assignee_uuid, version, tenant, created_at, updated_at) VALUES (%d, %s, %s, %s, %s, %s, %d, %s, %s, %s);',
                        ++$i,
                        $this->connection->quote($access->uuid),
                        $this->connection->quote($access->owner),
                        $this->connection->quote($access->owner_uuid),
                        $this->connection->quote($access->assignee),
                        $this->connection->quote($access->assignee_uuid),
                        $access->version,
                        $this->connection->quote($access->tenant),
                        'now()',
                        'now()'
                    ));

                    foreach ($access->permissions as $permission) {
                        $this->addSql(sprintf(
                            'INSERT INTO ds_access_permission (id, access_id, scope, entity, entity_uuid, key, attributes, tenant) VALUES (%d, %d, %s, %s, %s, %s, %s, %s);',
                            ++$j,
                            $i,
                            $this->connection->quote($permission->scope),
                            null === $permission->entity ? 'NULL' : $this->connection->quote($permission->entity),
                            null === $permission->entity_uuid ? 'NULL' : $this->connection->quote($permission->entity_uuid),
                            $this->connection->quote($permission->key),
                            $this->connection->quote(json_encode($permission->attributes)),
                            $this->connection->quote($access->tenant)
                        ));
                    }
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
                $this->addSql('ALTER TABLE ds_access_permission DROP CONSTRAINT FK_D46DD4D04FEA67CF');
                $this->addSql('DROP SEQUENCE ds_access_id_seq CASCADE');
                $this->addSql('DROP SEQUENCE ds_access_permission_id_seq CASCADE');
                $this->addSql('DROP TABLE ds_access');
                $this->addSql('DROP TABLE ds_access_permission');
                break;

            default:
                $this->abortIf(true,'Migration cannot be executed on "'.$this->platform->getName().'".');
                break;
        }
    }
}
