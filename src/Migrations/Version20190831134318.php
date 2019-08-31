<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190831134318 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, action_id INT NOT NULL, title VARCHAR(100) DEFAULT NULL, text LONGTEXT DEFAULT NULL, image VARCHAR(100) DEFAULT NULL, INDEX IDX_23A0E669D32F035 (action_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E669D32F035 FOREIGN KEY (action_id) REFERENCES action (id)');
        

        $articles = [
            ['action_id' => 3,
                'title' => "En quoi ça consiste ?",
                'text' => '<p>Le massage des tissus profonds utilise une pression ferme et des mouvements lents pour atteindre des couches profondes de muscle et de fascia (tissu conjonctif qui enveloppe les os, les articulations et les muscles).</p><p>Le travail se fait sur toute la longueur des fibres musculaires en utilisant les mains, le coude, l’avant-bras et les pouces.</p><p>Les techniques utilisées permettent le travail du muscle dans ses trois dimensions au lieu de simplement l&apos;écraser. Ainsi, le travail de relâchement au niveau des fascias est rendu possible, et donne plus d’espace au muscle, lui permettant de se relâcher plus aisément.</p><p>Le massage se fait sans huile, avec un peu de beurre de karité.</p>',
                'image' => 'deep-tissue.jpg'
            ],
            ['action_id' => 4,
                'title' => "Pour qui ?",
                'text' => '<p>Le massage des tissus profonds se concentre généralement sur un problème spécifique, comme une douleur musculaire chronique ou une rééducation après une blessure. Surtout destiné aux sportifs, il s&apos;avère efficace sur de nombreux problèmes, de posture,  de tensions musculaires ou d&apos;arthrose.</p><p>Les "sportifs du quotidien" y trouveront aussi beaucoup d&apos;avantages car on souffre également de rester statique au bureau ou dans un véhicule. Les gestes répétitifs, la fatigue physique et nerveuse provoquent des tensions qui  se transforment en douleurs persistantes. Les bienfaits du massage deep tissue vont plus loin que le travail sur les muscles et le soulagement de la douleur, puisqu&apos;il permet aussi de réduire la tension artérielle, la fréquence cardiaque et les niveaux d&apos;hormone de stress. Un massage aussi bon pour le corps que pour l&apos;esprit, il permet de se détendre et d&apos;être plus positif.</p>',
                'image' => 'deep-tissue.jpg'
            ],
            ['action_id' => 5,
                'title' => '',
                'text' => 'De récentes études menées dans différents pays ont démontrées les avantages des massages deep tissue par rapport aux massages classiques.</p><p><b>Soulage le mal de dos chronique</b> et entraîne une amélioration significative dans le temps.</p><h2>Réduit le stress, l’anxiété et la tension musculaire.</h2><p>L’inflammation causée par le stress chronique et les tensions musculaires peut entraîner une aggravation de la santé globale, un allongement des temps de récupération, une dégradation de la fonction immunitaire et des problèmes cardiovasculaires, comme l’hypertension artérielle. Des études ont révélé que les massages peuvent aider à réduire les taux de cortisol et même augmenter la production de l’hormone appelée oxytocine, qui détend le corps et entraîne des effets apaisants.</p><p>On a montré que le massage améliore la relaxation en stimulant l’activité du système nerveux parasympathique, mesurée par la fréquence cardiaque, la tension artérielle et la variabilité du rythme cardiaque.</p><h2>Réduit l’inflammation</h2><p>Le massage des tissus profonds est souvent utilisé dans le cadre de blessures, pour aider à briser le tissu cicatrisant nouvellement formé  qui peut rendre la récupération plus difficile et entraîner une rigidité. Le massage a été démontré utile pour aider à réduire l’inflammation et les spasmes musculaires en stimulant le flux sanguin, en relâchant les muscles pour fluidifier l’apport d’oxygène et en aidant également à réduire la réponse automatique au stress du système nerveux. Il contribue également au renouvellement de la lymphe qui entraine l&apos;évacuation des déchets métaboliques (drainage). D&apos;où l&apos;intérêt de beaucoup boire les jours qui suivent la massage.</p><p>Améliore la récupération et la performance des sportifs</p><p>Des études montrent que les massages tissulaires profonds peuvent aider à améliorer la clairance du lactate, l’apparition tardive de douleurs musculaires, la fatigue musculaire, la prévention des blessures et le traitement des blessures.</p><p>Réduit les symptômes de l’arthrite</p><p>Notamment les douleurs articulaires chroniques, la raideur, l’anxiété, les problèmes de mobilité liés aux articulations et les troubles du sommeil. Des massages fermes peuvent être utilisés quotidiennement pour un soulagement naturel.</p><p>Pour résumer il apportera un soulagement en cas de :<ul><li>baisse de la mobilité des muscles</li><li>lésions attribuables au travail répétitif</li><li>problèmes de posture</li><li>douleurs chroniques dues à une blessure</li><li>spasmes et tensions musculaires localisées</li><li>fibromyalgie</li><li>douleurs arthritiques</li></ul></p><p>Sans oublier un grand sentiment de légèreté, le massage des tissus profonds favorise la sécrétion d’endorphines, des hormones qui soulagent la douleur et qui procurent aussi un sentiment de bien-être. Il améliore la qualité du sommeil et favorise un relâchement des tensions musculaires prolongé.</p><p>Que du bonheur !</p>',
                'image' => 'deep-tissue.jpg'
            ],
            ['action_id' => 6,
                'title' => 'Durée et fréquence ?',
                'text' => '<p>Des séances d&apos;une heure minimum sont proposées. C&apos;est le temps nécessaire pour un lâcher-prise et une relaxation efficace. Vous verrez, le temps passe vite ... Il reste derrière la porte dès que le massage commence. Une séance d&apos;une heure et demi est des fois nécessaire pour travailler plus longuement sur des zones qui nécéssitent plus d&apos;attention.</p><p>En ce qui concerne la fréquence, il n&apos;y a pas de règle. Celà va dépendre de vos besoins. Par principe, toutes les 3 semaines à un mois pour un entretien. Rien n&apos;empêche de raccourcir ce délai si vous en ressentez le besoin.</p>',
                'image' => 'deep-tissue.jpg'
            ],
            ['action_id' => 7,
                'title' => 'Contre-indications',
                'text' => '<p>Elles sont les mêmes que celles d&apos;un massage classique à savoir que l&apos;on ne masse pas en cas de :<ul><li>Maladies virales, infectieuses</li><li>États fébriles/Fièvre</li><li>Affection cutanée</li><li>Inflammations graves</li><li>Cancer/Tumeur</li><li>Hémophilie</li><li>Phlébites</li><li>Problème cardiaque</li><li>Intervention chirurgicale de moins de 3 mois</li><li>Grossesse</li></ul></p><p>Contre-indications locales ou temporaires<ul><li>Diabète</li><li>Varices</li></ul></p><p>Le massage deep tissue nécéssite une pression plus importante que les massages classiques il faut donc rajouter :<ul><li>Fragilité osseuse / Ostéoporose</li><li>Hernies abdominales</li></ul></p><p>N&apos;hésitez pas à demander l&apos;avis de votre médecin en cas de doute.</p>',
                'image' => 'deep-tissue.jpg'
            ],
            ['action_id' => 8,
                'title' => 'Pratique',
                'text' => '<p>Nous allons faire Une pause ensemble et pour son bon déroulement, voici quelques conseils pour en profiter au mieux.</p><p>La première fois, nous remplirons ensemble un questionnaire afin de vérifier que vous ne présentez pas de contre-indications et pour que vous puissiez me communiquer vos attentes.</p><p>Mette-vous à l&apos;aise, détendez-vous au maximum et savourez le moment !</p><p>N&apos;hésitez pas à dire si vous êtes mal installé, si vous avez froid (car la température du corps baisse durant le massage) ou si vous ressentez la moindre douleur. Je reste à votre écoute tout au long de la séance.</p><p>Après votre massage, prenez le temps de revenir à vous et de vous relever tout doucement, sans forcer, pour laisser à votre corps le temps de se réveiller. Dans les heures qui suivent il vous faut du repos et une bonne hydratation pour éliminer les toxines qui ont été délogées.</p><p>Pour garder les bienfaïts du beurre de karité et des éventuelles huiles essentielles, vous pouvez les laisser sur votre peau après le massage et ne prendre votre douche qu’en soirée. Votre peau pourra ainsi être nourrie en profondeur.</p><p>Les massages doivent être faits à distance des repas, la pression provoquerait un inconfort gastrique.</p>',
                'image' => 'beurre-de-karite.jpg'
            ],
        ];

        foreach($articles as $article) {
            $this->addSql('INSERT INTO article (action_id, title, text, image) VALUES (:action_id, :title, :text, :image)', $article);
        }
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE article');
    }
}
