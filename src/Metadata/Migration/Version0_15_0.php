<?php

namespace Ds\Component\Metadata\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Class Version0_15_0
 *
 * @package Ds\Component\Metadata
 */
final class Version0_15_0 extends AbstractMigration
{
    /**
     * Up migration
     *
     * @param \Doctrine\DBAL\Schema\Schema $schema
     * @param array $metadatas
     */
    public function up(Schema $schema, array $metadatas = [])
    {
        $sequences['ds_metadata_id_seq'] = 1 + count($metadatas);
        $sequences['ds_metadata_trans_id_seq'] = 1;

        foreach ($metadatas as $metadata) {
            $sequences['ds_metadata_trans_id_seq'] += count($metadata->title);
        }

        switch ($this->platform->getName()) {
            case 'postgresql':
                $this->addSql('CREATE SEQUENCE ds_metadata_id_seq INCREMENT BY 1 MINVALUE 1 START '.$sequences['ds_metadata_id_seq']);
                $this->addSql('CREATE SEQUENCE ds_metadata_trans_id_seq INCREMENT BY 1 MINVALUE 1 START '.$sequences['ds_metadata_trans_id_seq']);
                $this->addSql('CREATE TABLE ds_metadata (id INT NOT NULL, uuid UUID NOT NULL, "owner" VARCHAR(255) DEFAULT NULL, owner_uuid UUID DEFAULT NULL, slug VARCHAR(255) NOT NULL, type VARCHAR(255) DEFAULT NULL, data JSON NOT NULL, version INT DEFAULT 1 NOT NULL, tenant UUID NOT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
                $this->addSql('CREATE UNIQUE INDEX UNIQ_11290F17D17F50A6 ON ds_metadata (uuid)');
                $this->addSql('CREATE UNIQUE INDEX UNIQ_11290F17989D9B624E59C462 ON ds_metadata (slug, tenant)');
                $this->addSql('COMMENT ON COLUMN ds_metadata.data IS \'(DC2Type:json_array)\'');
                $this->addSql('CREATE TABLE ds_metadata_trans (id INT NOT NULL, translatable_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, locale VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
                $this->addSql('CREATE INDEX IDX_A6447E202C2AC5D3 ON ds_metadata_trans (translatable_id)');
                $this->addSql('CREATE UNIQUE INDEX ds_metadata_trans_unique_translation ON ds_metadata_trans (translatable_id, locale)');
                $this->addSql('ALTER TABLE ds_metadata_trans ADD CONSTRAINT FK_A6447E202C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES ds_metadata (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
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
                $this->addSql('ALTER TABLE ds_metadata_trans DROP CONSTRAINT FK_A6447E202C2AC5D3');
                $this->addSql('DROP SEQUENCE ds_metadata_id_seq CASCADE');
                $this->addSql('DROP SEQUENCE ds_metadata_trans_id_seq CASCADE');
                $this->addSql('DROP TABLE ds_metadata');
                $this->addSql('DROP TABLE ds_metadata_trans');
                break;

            default:
                $this->abortIf(true,'Migration cannot be executed on "'.$this->platform->getName().'".');
                break;
        }
    }
}
