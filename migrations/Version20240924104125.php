<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240924104125 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE feed_back_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE feed_back_session_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE feedback_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE participated_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE feedback (id INT NOT NULL, type VARCHAR(100) NOT NULL, content TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN feedback.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE participated (id INT NOT NULL, user_id_id INT DEFAULT NULL, date DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B0D2F0E39D86650F ON participated (user_id_id)');
        $this->addSql('ALTER TABLE participated ADD CONSTRAINT FK_B0D2F0E39D86650F FOREIGN KEY (user_id_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE feed_back DROP CONSTRAINT fk_ed592a60613fecdf');
        $this->addSql('DROP TABLE feed_back');
        $this->addSql('DROP TABLE feed_back_session');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE feedback_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE participated_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE feed_back_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE feed_back_session_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE feed_back (id INT NOT NULL, session_id INT NOT NULL, type VARCHAR(100) NOT NULL, content TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_ed592a60613fecdf ON feed_back (session_id)');
        $this->addSql('COMMENT ON COLUMN feed_back.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE feed_back_session (id INT NOT NULL, session_id VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN feed_back_session.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE feed_back ADD CONSTRAINT fk_ed592a60613fecdf FOREIGN KEY (session_id) REFERENCES feed_back_session (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE participated DROP CONSTRAINT FK_B0D2F0E39D86650F');
        $this->addSql('DROP TABLE feedback');
        $this->addSql('DROP TABLE participated');
    }
}
