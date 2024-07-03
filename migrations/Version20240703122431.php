<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240703122431 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE progression (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, etape_id INT NOT NULL, done TINYINT(1) NOT NULL, INDEX IDX_D5B25073FB88E14F (utilisateur_id), INDEX IDX_D5B250734A8CA2AD (etape_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE progression ADD CONSTRAINT FK_D5B25073FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE progression ADD CONSTRAINT FK_D5B250734A8CA2AD FOREIGN KEY (etape_id) REFERENCES etape (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE progression DROP FOREIGN KEY FK_D5B25073FB88E14F');
        $this->addSql('ALTER TABLE progression DROP FOREIGN KEY FK_D5B250734A8CA2AD');
        $this->addSql('DROP TABLE progression');
    }
}