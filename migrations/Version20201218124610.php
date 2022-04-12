<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201218124610 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE rate (id INT AUTO_INCREMENT NOT NULL, post_id INT DEFAULT NULL, value INT NOT NULL, UNIQUE INDEX UNIQ_DFEC3F394B89032C (post_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vote (id INT AUTO_INCREMENT NOT NULL, rate_id INT NOT NULL, value INT NOT NULL, INDEX IDX_5A108564BC999F9F (rate_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE rate ADD CONSTRAINT FK_DFEC3F394B89032C FOREIGN KEY (post_id) REFERENCES post (id)');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A108564BC999F9F FOREIGN KEY (rate_id) REFERENCES post (id)');
        $this->addSql('ALTER TABLE post ADD rate_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DBC999F9F FOREIGN KEY (rate_id) REFERENCES rate (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5A8A6C8DBC999F9F ON post (rate_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DBC999F9F');
        $this->addSql('DROP TABLE rate');
        $this->addSql('DROP TABLE vote');
        $this->addSql('DROP INDEX UNIQ_5A8A6C8DBC999F9F ON post');
        $this->addSql('ALTER TABLE post DROP rate_id');
    }
}
