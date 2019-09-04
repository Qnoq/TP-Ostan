<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190903110511 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE comment ADD status_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C6BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('CREATE INDEX IDX_9474526C6BF700BD ON comment (status_id)');
        $this->addSql('ALTER TABLE user ADD status_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6496BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6496BF700BD ON user (status_id)');
        $this->addSql('ALTER TABLE status DROP FOREIGN KEY FK_7B00651C4F34D596');
        $this->addSql('ALTER TABLE status DROP FOREIGN KEY FK_7B00651CA76ED395');
        $this->addSql('ALTER TABLE status DROP FOREIGN KEY FK_7B00651CF8697D13');
        $this->addSql('DROP INDEX IDX_7B00651C4F34D596 ON status');
        $this->addSql('DROP INDEX IDX_7B00651CA76ED395 ON status');
        $this->addSql('DROP INDEX IDX_7B00651CF8697D13 ON status');
        $this->addSql('ALTER TABLE status DROP user_id, DROP ad_id, DROP comment_id');
        $this->addSql('ALTER TABLE ad ADD status_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ad ADD CONSTRAINT FK_77E0ED586BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('CREATE INDEX IDX_77E0ED586BF700BD ON ad (status_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ad DROP FOREIGN KEY FK_77E0ED586BF700BD');
        $this->addSql('DROP INDEX IDX_77E0ED586BF700BD ON ad');
        $this->addSql('ALTER TABLE ad DROP status_id');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C6BF700BD');
        $this->addSql('DROP INDEX IDX_9474526C6BF700BD ON comment');
        $this->addSql('ALTER TABLE comment DROP status_id');
        $this->addSql('ALTER TABLE status ADD user_id INT DEFAULT NULL, ADD ad_id INT DEFAULT NULL, ADD comment_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE status ADD CONSTRAINT FK_7B00651C4F34D596 FOREIGN KEY (ad_id) REFERENCES ad (id)');
        $this->addSql('ALTER TABLE status ADD CONSTRAINT FK_7B00651CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE status ADD CONSTRAINT FK_7B00651CF8697D13 FOREIGN KEY (comment_id) REFERENCES comment (id)');
        $this->addSql('CREATE INDEX IDX_7B00651C4F34D596 ON status (ad_id)');
        $this->addSql('CREATE INDEX IDX_7B00651CA76ED395 ON status (user_id)');
        $this->addSql('CREATE INDEX IDX_7B00651CF8697D13 ON status (comment_id)');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6496BF700BD');
        $this->addSql('DROP INDEX IDX_8D93D6496BF700BD ON user');
        $this->addSql('ALTER TABLE user DROP status_id');
    }
}
