<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191010110012 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE person ADD skills VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE skill DROP FOREIGN KEY FK_5E3DE477217BBB47');
        $this->addSql('DROP INDEX IDX_5E3DE477217BBB47 ON skill');
        $this->addSql('ALTER TABLE skill ADD person VARCHAR(255) NOT NULL, DROP person_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE person DROP skills');
        $this->addSql('ALTER TABLE skill ADD person_id INT DEFAULT NULL, DROP person');
        $this->addSql('ALTER TABLE skill ADD CONSTRAINT FK_5E3DE477217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
        $this->addSql('CREATE INDEX IDX_5E3DE477217BBB47 ON skill (person_id)');
    }
}
