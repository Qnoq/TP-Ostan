<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190903104409 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user_job (user_id INT NOT NULL, job_id INT NOT NULL, INDEX IDX_10CE8173A76ED395 (user_id), INDEX IDX_10CE8173BE04EA9 (job_id), PRIMARY KEY(user_id, job_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_tag (user_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_E89FD608A76ED395 (user_id), INDEX IDX_E89FD608BAD26311 (tag_id), PRIMARY KEY(user_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ad_tag (ad_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_717EDDB44F34D596 (ad_id), INDEX IDX_717EDDB4BAD26311 (tag_id), PRIMARY KEY(ad_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_job ADD CONSTRAINT FK_10CE8173A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_job ADD CONSTRAINT FK_10CE8173BE04EA9 FOREIGN KEY (job_id) REFERENCES job (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_tag ADD CONSTRAINT FK_E89FD608A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_tag ADD CONSTRAINT FK_E89FD608BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ad_tag ADD CONSTRAINT FK_717EDDB44F34D596 FOREIGN KEY (ad_id) REFERENCES ad (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ad_tag ADD CONSTRAINT FK_717EDDB4BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE comment ADD ad_id INT DEFAULT NULL, ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C4F34D596 FOREIGN KEY (ad_id) REFERENCES ad (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_9474526C4F34D596 ON comment (ad_id)');
        $this->addSql('CREATE INDEX IDX_9474526CA76ED395 ON comment (user_id)');
        $this->addSql('ALTER TABLE user ADD role_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D60322AC FOREIGN KEY (role_id) REFERENCES role (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649D60322AC ON user (role_id)');
        $this->addSql('ALTER TABLE message ADD user_id INT DEFAULT NULL, ADD user_receiver_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F64482423 FOREIGN KEY (user_receiver_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_B6BD307FA76ED395 ON message (user_id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F64482423 ON message (user_receiver_id)');
        $this->addSql('ALTER TABLE advice_post ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE advice_post ADD CONSTRAINT FK_4D267ECBA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_4D267ECBA76ED395 ON advice_post (user_id)');
        $this->addSql('ALTER TABLE gallery_post ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE gallery_post ADD CONSTRAINT FK_C9954401A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_C9954401A76ED395 ON gallery_post (user_id)');
        $this->addSql('ALTER TABLE status ADD user_id INT DEFAULT NULL, ADD ad_id INT DEFAULT NULL, ADD comment_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE status ADD CONSTRAINT FK_7B00651CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE status ADD CONSTRAINT FK_7B00651C4F34D596 FOREIGN KEY (ad_id) REFERENCES ad (id)');
        $this->addSql('ALTER TABLE status ADD CONSTRAINT FK_7B00651CF8697D13 FOREIGN KEY (comment_id) REFERENCES comment (id)');
        $this->addSql('CREATE INDEX IDX_7B00651CA76ED395 ON status (user_id)');
        $this->addSql('CREATE INDEX IDX_7B00651C4F34D596 ON status (ad_id)');
        $this->addSql('CREATE INDEX IDX_7B00651CF8697D13 ON status (comment_id)');
        $this->addSql('ALTER TABLE ad ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ad ADD CONSTRAINT FK_77E0ED58A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_77E0ED58A76ED395 ON ad (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE user_job');
        $this->addSql('DROP TABLE user_tag');
        $this->addSql('DROP TABLE ad_tag');
        $this->addSql('ALTER TABLE ad DROP FOREIGN KEY FK_77E0ED58A76ED395');
        $this->addSql('DROP INDEX IDX_77E0ED58A76ED395 ON ad');
        $this->addSql('ALTER TABLE ad DROP user_id');
        $this->addSql('ALTER TABLE advice_post DROP FOREIGN KEY FK_4D267ECBA76ED395');
        $this->addSql('DROP INDEX IDX_4D267ECBA76ED395 ON advice_post');
        $this->addSql('ALTER TABLE advice_post DROP user_id');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C4F34D596');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CA76ED395');
        $this->addSql('DROP INDEX IDX_9474526C4F34D596 ON comment');
        $this->addSql('DROP INDEX IDX_9474526CA76ED395 ON comment');
        $this->addSql('ALTER TABLE comment DROP ad_id, DROP user_id');
        $this->addSql('ALTER TABLE gallery_post DROP FOREIGN KEY FK_C9954401A76ED395');
        $this->addSql('DROP INDEX IDX_C9954401A76ED395 ON gallery_post');
        $this->addSql('ALTER TABLE gallery_post DROP user_id');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FA76ED395');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F64482423');
        $this->addSql('DROP INDEX IDX_B6BD307FA76ED395 ON message');
        $this->addSql('DROP INDEX IDX_B6BD307F64482423 ON message');
        $this->addSql('ALTER TABLE message DROP user_id, DROP user_receiver_id');
        $this->addSql('ALTER TABLE status DROP FOREIGN KEY FK_7B00651CA76ED395');
        $this->addSql('ALTER TABLE status DROP FOREIGN KEY FK_7B00651C4F34D596');
        $this->addSql('ALTER TABLE status DROP FOREIGN KEY FK_7B00651CF8697D13');
        $this->addSql('DROP INDEX IDX_7B00651CA76ED395 ON status');
        $this->addSql('DROP INDEX IDX_7B00651C4F34D596 ON status');
        $this->addSql('DROP INDEX IDX_7B00651CF8697D13 ON status');
        $this->addSql('ALTER TABLE status DROP user_id, DROP ad_id, DROP comment_id');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D60322AC');
        $this->addSql('DROP INDEX IDX_8D93D649D60322AC ON user');
        $this->addSql('ALTER TABLE user DROP role_id');
    }
}
