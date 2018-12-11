<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181211124812 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE information ADD idbooking_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE information ADD CONSTRAINT FK_29791883CE99015A FOREIGN KEY (idbooking_id) REFERENCES booking (id)');
        $this->addSql('CREATE INDEX IDX_29791883CE99015A ON information (idbooking_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE information DROP FOREIGN KEY FK_29791883CE99015A');
        $this->addSql('DROP INDEX IDX_29791883CE99015A ON information');
        $this->addSql('ALTER TABLE information DROP idbooking_id');
    }
}
