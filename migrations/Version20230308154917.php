<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230308154917 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE entradas ADD objetos_id INT NOT NULL');
        $this->addSql('ALTER TABLE entradas ADD CONSTRAINT FK_4CAF338C420DFD83 FOREIGN KEY (objetos_id) REFERENCES objetos (id)');
        $this->addSql('CREATE INDEX IDX_4CAF338C420DFD83 ON entradas (objetos_id)');
        $this->addSql('ALTER TABLE objetos ADD ubicacion_id INT NOT NULL');
        $this->addSql('ALTER TABLE objetos ADD CONSTRAINT FK_245B29C57E759E8 FOREIGN KEY (ubicacion_id) REFERENCES ubicacion (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_245B29C57E759E8 ON objetos (ubicacion_id)');
        $this->addSql('ALTER TABLE salidas ADD objetos_id INT NOT NULL');
        $this->addSql('ALTER TABLE salidas ADD CONSTRAINT FK_639CF26E420DFD83 FOREIGN KEY (objetos_id) REFERENCES objetos (id)');
        $this->addSql('CREATE INDEX IDX_639CF26E420DFD83 ON salidas (objetos_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE entradas DROP FOREIGN KEY FK_4CAF338C420DFD83');
        $this->addSql('DROP INDEX IDX_4CAF338C420DFD83 ON entradas');
        $this->addSql('ALTER TABLE entradas DROP objetos_id');
        $this->addSql('ALTER TABLE objetos DROP FOREIGN KEY FK_245B29C57E759E8');
        $this->addSql('DROP INDEX UNIQ_245B29C57E759E8 ON objetos');
        $this->addSql('ALTER TABLE objetos DROP ubicacion_id');
        $this->addSql('ALTER TABLE salidas DROP FOREIGN KEY FK_639CF26E420DFD83');
        $this->addSql('DROP INDEX IDX_639CF26E420DFD83 ON salidas');
        $this->addSql('ALTER TABLE salidas DROP objetos_id');
    }
}
