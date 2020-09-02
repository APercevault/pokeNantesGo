<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200827101751 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, id_user_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, content VARCHAR(255) NOT NULL, image LONGTEXT NOT NULL, active TINYINT(1) NOT NULL, INDEX IDX_23A0E6679F37AE5 (id_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentary (id INT AUTO_INCREMENT NOT NULL, id_user_id INT DEFAULT NULL, id_article_id INT DEFAULT NULL, content VARCHAR(255) NOT NULL, INDEX IDX_1CAC12CA79F37AE5 (id_user_id), INDEX IDX_1CAC12CAD71E064B (id_article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sortie (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, content VARCHAR(255) NOT NULL, number_user INT NOT NULL, location VARCHAR(255) NOT NULL, date DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sortie_user (sortie_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_8A67684ACC72D953 (sortie_id), INDEX IDX_8A67684AA76ED395 (user_id), PRIMARY KEY(sortie_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E6679F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE commentary ADD CONSTRAINT FK_1CAC12CA79F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE commentary ADD CONSTRAINT FK_1CAC12CAD71E064B FOREIGN KEY (id_article_id) REFERENCES article (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentary DROP FOREIGN KEY FK_1CAC12CAD71E064B');
        $this->addSql('ALTER TABLE sortie_user DROP FOREIGN KEY FK_8A67684ACC72D953');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E6679F37AE5');
        $this->addSql('ALTER TABLE commentary DROP FOREIGN KEY FK_1CAC12CA79F37AE5');
        $this->addSql('ALTER TABLE sortie_user DROP FOREIGN KEY FK_8A67684AA76ED395');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE commentary');
        $this->addSql('DROP TABLE sortie');
        $this->addSql('DROP TABLE sortie_user');
        $this->addSql('DROP TABLE user');
    }
}
