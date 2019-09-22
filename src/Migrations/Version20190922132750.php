<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190922132750 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE parameter (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, value VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $parameters = [
            [
                'name' => 'company',
                'value' => 'Une pause',
            ],
            [
                'name' => 'adress',
                'value' => '41 bis rue Jacques Callot',
            ],
            [
                'name' => 'postal_code',
                'value' => '54550',
            ],
            [
                'name' => 'town',
                'value' => 'Bainville sur Madon',
            ],
            [
                'name' => 'phone_number',
                'value' => '06 32 59 58 27',
            ],
            [
                'name' => 'email',
                'value' => 'sophie@une-pause.fr',
            ],
        ];
        foreach($parameters as $parameter) {
            $this->addSql('INSERT INTO parameter (name, value) VALUES (:name, :value)', $parameter);
        }
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE parameter');
    }
}
