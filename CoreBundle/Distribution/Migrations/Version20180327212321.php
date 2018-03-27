<?php declare(strict_types = 1);

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180327212321 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE beaver_block (id INT AUTO_INCREMENT NOT NULL, published TINYINT(1) NOT NULL, page_id INT NOT NULL, area VARCHAR(50) NOT NULL, view VARCHAR(255) NOT NULL, order_block INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE beaver_block_template (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, view VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE beaver_page (id INT AUTO_INCREMENT NOT NULL, published TINYINT(1) NOT NULL, name VARCHAR(50) NOT NULL, slug VARCHAR(50) NOT NULL, layout VARCHAR(50) NOT NULL, theme VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE beaver_widget (id INT AUTO_INCREMENT NOT NULL, block_id INT NOT NULL, slot INT NOT NULL, widget VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE beaver_widget_size (widget_id INT NOT NULL, size INT NOT NULL, PRIMARY KEY(widget_id, size)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE beaver_widget_template (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, view VARCHAR(255) NOT NULL, content_type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE beaver_user (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, lastname VARCHAR(70) NOT NULL, status INT NOT NULL, rol INT NOT NULL, email VARCHAR(70) NOT NULL, username VARCHAR(50) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE beaver_block');
        $this->addSql('DROP TABLE beaver_block_template');
        $this->addSql('DROP TABLE beaver_page');
        $this->addSql('DROP TABLE beaver_widget');
        $this->addSql('DROP TABLE beaver_widget_size');
        $this->addSql('DROP TABLE beaver_widget_template');
        $this->addSql('DROP TABLE beaver_user');
    }
}
