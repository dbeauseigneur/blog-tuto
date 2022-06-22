<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220622143117 extends AbstractMigration
{
	public function getDescription(): string
	{
		return 'initialize database';
	}

	public function up(Schema $schema): void
	{
		// this up() migration is auto-generated, please modify it to your needs
		$this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, category_name VARCHAR(30) NOT NULL, slug VARCHAR(30) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
		$this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, post_id_id INT NOT NULL, author VARCHAR(40) NOT NULL, author_email VARCHAR(50) NOT NULL, title VARCHAR(150) DEFAULT NULL, content LONGTEXT NOT NULL, date DATETIME NOT NULL, approved TINYINT(1) NOT NULL, my_answer LONGTEXT DEFAULT NULL, INDEX IDX_9474526CE85F12B8 (post_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
		$this->addSql('CREATE TABLE post (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, link VARCHAR(255) NOT NULL, publication_date DATETIME DEFAULT NULL, content LONGTEXT DEFAULT NULL, open_comment TINYINT(1) DEFAULT NULL, statut TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
		$this->addSql('CREATE TABLE tuto (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, url VARCHAR(255) NOT NULL, name_url VARCHAR(60) DEFAULT NULL, date DATETIME NOT NULL, published TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
		$this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
		$this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CE85F12B8 FOREIGN KEY (post_id_id) REFERENCES post (id)');
	}

	public function down(Schema $schema): void
	{
		// this down() migration is auto-generated, please modify it to your needs
		$this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CE85F12B8');
		$this->addSql('DROP TABLE category');
		$this->addSql('DROP TABLE comment');
		$this->addSql('DROP TABLE post');
		$this->addSql('DROP TABLE tuto');
		$this->addSql('DROP TABLE messenger_messages');
	}
}
