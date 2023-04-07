<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230407080211 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, category VARCHAR(255) NOT NULL, icone_url VARCHAR(255) NOT NULL, color VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formations (id INT AUTO_INCREMENT NOT NULL, sanction_id INT DEFAULT NULL, university_id INT NOT NULL, title VARCHAR(255) NOT NULL, generality LONGTEXT NOT NULL, prerequisite LONGTEXT DEFAULT NULL, purpose LONGTEXT NOT NULL, finality LONGTEXT DEFAULT NULL, contents LONGTEXT NOT NULL, prices INT DEFAULT NULL, duration VARCHAR(255) DEFAULT NULL, priority TINYINT(1) NOT NULL, vignette_url VARCHAR(255) NOT NULL, INDEX IDX_4090213796E0C11A (sanction_id), INDEX IDX_40902137309D1878 (university_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formations_categories (formations_id INT NOT NULL, categories_id INT NOT NULL, INDEX IDX_1B7E00B23BF5B0C2 (formations_id), INDEX IDX_1B7E00B2A21214B7 (categories_id), PRIMARY KEY(formations_id, categories_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, mail VARCHAR(255) NOT NULL, subject VARCHAR(255) DEFAULT NULL, message LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sanctions (id INT AUTO_INCREMENT NOT NULL, sanction VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE universities (id INT AUTO_INCREMENT NOT NULL, university VARCHAR(255) NOT NULL, logo_url VARCHAR(255) NOT NULL, login_url VARCHAR(255) NOT NULL, site_url VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE formations ADD CONSTRAINT FK_4090213796E0C11A FOREIGN KEY (sanction_id) REFERENCES sanctions (id)');
        $this->addSql('ALTER TABLE formations ADD CONSTRAINT FK_40902137309D1878 FOREIGN KEY (university_id) REFERENCES universities (id)');
        $this->addSql('ALTER TABLE formations_categories ADD CONSTRAINT FK_1B7E00B23BF5B0C2 FOREIGN KEY (formations_id) REFERENCES formations (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formations_categories ADD CONSTRAINT FK_1B7E00B2A21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE formations DROP FOREIGN KEY FK_4090213796E0C11A');
        $this->addSql('ALTER TABLE formations DROP FOREIGN KEY FK_40902137309D1878');
        $this->addSql('ALTER TABLE formations_categories DROP FOREIGN KEY FK_1B7E00B23BF5B0C2');
        $this->addSql('ALTER TABLE formations_categories DROP FOREIGN KEY FK_1B7E00B2A21214B7');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE formations');
        $this->addSql('DROP TABLE formations_categories');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE sanctions');
        $this->addSql('DROP TABLE universities');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
