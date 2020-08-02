<?php

namespace Ds\Component\Acl\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Class Version0_19_0
 *
 * @package Ds\Component\Acl
 */
final class Version0_19_0 extends AbstractMigration
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
                $this->addSql('ALTER TABLE ds_access_permission ADD scope JSON DEFAULT \'{}\'');
                $this->addSql('
                    UPDATE
                        ds_access_permission
                    SET
                        scope = CONCAT(
                            \'{\',
                            \'"type": "\', scope_type, \'"\',
                            CASE WHEN scope_entity IS NOT NULL THEN CONCAT(\', "entity": "\', scope_entity, \'"\') ELSE \'\' END,
                            CASE WHEN scope_entity_uuid IS NOT NULL THEN CONCAT(\', "entity_uuid": "\', scope_entity_uuid, \'"\') ELSE \'\' END,
                            \'}\')::jsonb
                ');
                $this->addSql('ALTER TABLE ds_access_permission ALTER scope DROP DEFAULT');
                $this->addSql('ALTER TABLE ds_access_permission ALTER scope SET NOT NULL');
                $this->addSql('COMMENT ON COLUMN ds_access_permission.scope IS \'(DC2Type:json_array)\'');
                $this->addSql('ALTER TABLE ds_access_permission DROP COLUMN scope_type');
                $this->addSql('ALTER TABLE ds_access_permission DROP COLUMN scope_entity');
                $this->addSql('ALTER TABLE ds_access_permission DROP COLUMN scope_entity_uuid');
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
                $this->addSql('ALTER TABLE ds_access_permission ADD scope_type VARCHAR(32) DEFAULT NULL');
                $this->addSql('ALTER TABLE ds_access_permission ADD scope_entity VARCHAR(32) DEFAULT NULL');
                $this->addSql('ALTER TABLE ds_access_permission ADD scope_entity_uuid VARCHAR(36) DEFAULT NULL');
                $this->addSql('UPDATE ds_access_permission SET scope_type = scope ->> \'type\', scope_entity = scope ->> \'entity\', scope_entity_uuid = scope ->> \'entity_uuid\'');
                $this->addSql('ALTER TABLE ds_access_permission DROP COLUMN scope');
                break;

            default:
                $this->abortIf(true,'Migration cannot be executed on "'.$this->platform->getName().'".');
                break;
        }
    }
}
