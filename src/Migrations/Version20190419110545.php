<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190419110545 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE basket_product DROP FOREIGN KEY FK_17ED14B44584665A');
        $this->addSql('DROP INDEX FK_17ED14B44584665A ON basket_product');
        $this->addSql('ALTER TABLE basket_product CHANGE product_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE basket_product ADD CONSTRAINT FK_17ED14B4A76ED395 FOREIGN KEY (user_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE basket_product ADD CONSTRAINT FK_17ED14B41BE1FB52 FOREIGN KEY (basket_id) REFERENCES basket (id)');
        $this->addSql('CREATE INDEX IDX_17ED14B4A76ED395 ON basket_product (user_id)');
        $this->addSql('CREATE INDEX IDX_17ED14B41BE1FB52 ON basket_product (basket_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE basket_product DROP FOREIGN KEY FK_17ED14B4A76ED395');
        $this->addSql('ALTER TABLE basket_product DROP FOREIGN KEY FK_17ED14B41BE1FB52');
        $this->addSql('DROP INDEX IDX_17ED14B4A76ED395 ON basket_product');
        $this->addSql('DROP INDEX IDX_17ED14B41BE1FB52 ON basket_product');
        $this->addSql('ALTER TABLE basket_product CHANGE user_id product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE basket_product ADD CONSTRAINT FK_17ED14B44584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX FK_17ED14B44584665A ON basket_product (product_id)');
    }
}
