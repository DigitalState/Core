<?php

namespace Ds\Component\Acl\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Class Version0_17_0
 *
 * @package Ds\Component\Acl
 */
final class Version0_17_0 extends AbstractMigration
{
    /**
     * Up migration
     *
     * @param \Doctrine\DBAL\Schema\Schema $schema
     */
    public function up(Schema $schema)
    {
        switch ($this->platform->getName()) {
            case 'postgresql':
                $this->addSql('ALTER TABLE ds_access_permission ADD scope_type VARCHAR(32) DEFAULT NULL');
                $this->addSql('ALTER TABLE ds_access_permission ADD scope_entity VARCHAR(32) DEFAULT NULL');
                $this->addSql('ALTER TABLE ds_access_permission ADD scope_entity_uuid VARCHAR(36) DEFAULT NULL');
                $this->addSql('UPDATE ds_access_permission SET scope_type = scope, scope_entity = entity, scope_entity_uuid = entity_uuid');
                $this->addSql('ALTER TABLE ds_access_permission DROP scope');
                $this->addSql('ALTER TABLE ds_access_permission DROP entity');
                $this->addSql('ALTER TABLE ds_access_permission DROP entity_uuid');
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
                $this->addSql('ALTER TABLE ds_access_permission ADD scope VARCHAR(255) DEFAULT NULL');
                $this->addSql('ALTER TABLE ds_access_permission ADD entity VARCHAR(255) DEFAULT NULL');
                $this->addSql('ALTER TABLE ds_access_permission ADD entity_uuid UUID DEFAULT NULL');
                $this->addSql('UPDATE ds_access_permission SET scope = scope_type, entity = scope_entity, entity_uuid = scope_entity_uuid::uuid');
                $this->addSql('ALTER TABLE ds_access_permission DROP scope_type');
                $this->addSql('ALTER TABLE ds_access_permission DROP scope_entity');
                $this->addSql('ALTER TABLE ds_access_permission DROP scope_entity_uuid');
                break;

            default:
                $this->abortIf(true,'Migration cannot be executed on "'.$this->platform->getName().'".');
                break;
        }
    }
}
