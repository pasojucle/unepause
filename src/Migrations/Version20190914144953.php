<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190914144953 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE container (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, tag_name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE action_container (action_id INT NOT NULL, container_id INT NOT NULL, INDEX IDX_63A4FF069D32F035 (action_id), INDEX IDX_63A4FF06BC21F742 (container_id), PRIMARY KEY(action_id, container_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE action_container ADD CONSTRAINT FK_63A4FF069D32F035 FOREIGN KEY (action_id) REFERENCES action (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE action_container ADD CONSTRAINT FK_63A4FF06BC21F742 FOREIGN KEY (container_id) REFERENCES container (id) ON DELETE CASCADE');

        $actions = [
            [
                'id' => 8,
                'name' => 'Mentions légales',
                'slug' =>'legal_notice',
            ],
            [
                'id' => 9,
                'name' => 'Conditions générales de vente',
                'slug' =>'terms_of_sales',
            ],
        ];
        foreach($actions as $action) {
            $this->addSql('INSERT INTO action (id, name, slug) VALUES (:id, :name, :slug)', $action);
        }

        $containers = [
            [
                'id' => 1,
                'name' => 'Menu',
                'tagName' =>'nav',
            ],
            [
                'id' => 2,
                'name' => 'Pied de page',
                'tagName' =>'footer',
            ],
        ];
        foreach($containers as $container) {
            $this->addSql('INSERT INTO container (id, name, tag_name) VALUES (:id, :name, :tagName)', $container);
        }

        $actionContainers = [
            [
                'actionId' => 1,
                'containerId' => 1,
            ],
            [
                'actionId' => 2,
                'containerId' => 1,
            ],
            [
                'actionId' => 3,
                'containerId' => 1,
            ],
            [
                'actionId' => 4,
                'containerId' => 1,
            ],
            [
                'actionId' => 5,
                'containerId' => 1,
            ],
            [
                'actionId' => 6,
                'containerId' => 1,
            ],
            [
                'actionId' => 7,
                'containerId' => 1,
            ],
            [
                'actionId' => 7,
                'containerId' => 2,
            ],
            [
                'actionId' => 8,
                'containerId' => 2,
            ],
            [
                'actionId' => 9,
                'containerId' => 2,
            ],
        ];
        foreach($actionContainers as $actionContainer) {
            $this->addSql('INSERT INTO action_container (action_id, container_id) VALUES (:actionId, :containerId)', $actionContainer);
        }

        $pages = [
            [
                'id' => 12,
                'name' => 'Mentions légales',
                'templateId' => 2,
                'actionId' => 8,
                'slug' => 'legale_notice',
            ],
            [
                'id' => 13,
                'name' => 'Conditions générales de vente',
                'templateId' => 2,
                'actionId' => 9,
                'slug' => 'term_of_sales',
            ],
        ];
        foreach($pages as $page) {
            $this->addSql('INSERT INTO page (id, name, template_id, action_id, slug) VALUES (:id, :name, :templateId, :actionId, :slug)', $page);
        }

        $articles = [
            ['title' => "Mentions légales",
                'content' => '<h2>Directeurs de publication :</h2><p>Sophie Boulangé<br>SIREN 507 421 683 00024<br>sophie@une-pause.fr</p><h2>Hébergeur :</h2><p>OVH net<br>140, Quai du Sartel<br>59100 Roubaix<br>France<br>+33 8 99 70 17 61<br>tech@ovh.net</p><h2>Réalisation :</h2><p>Patrick Boulangé<br>pab54.free.fr<br>pab54@free.fr</p><h2>Propriété intellectuelle :</h2><p>Toutes les photographies de ce site sont la propriété exclusive de « Une Pause » et protégées par les lois internationales sur le copyright et le code de la propriété intellectuelle.</p><p>Elles ne peuvent être utilisées, sous quelque forme que ce soit, sans une autorisation écrite de son auteur, ou sans avoir signé un contrat de cession de droits d&apos;auteur pour un usage commercial.</p><h2>Données collectées :</h2><p>Conformément à la loi « informatique et libertés » du 6 janvier 1978, vous bénéficiez d&apos;un droit d&apos;accès et de rectification aux informations qui vous concernent.</p><p>Si vous souhaitez exercer ce droit et obtenir la communication des informations vous concernant, le retrait d’une photo au nom du droit à l’image, veuillez me contacter en laissant un message via formulaire de contact.</p><h2>Cookies :</h2><p>Notre site utilise des cookies pour suivre les préférences des utilisateurs et optimiser la structure du site internet. Les cookies sont des petits fichiers stockés temporairement sur l’ordinateur, le mobile ou la tablette de l’utilisateur. Ces cookies n’existent que jusqu’à la fin de la session internet. Ils sont utilisés pour la navigation et améliorent la convivialité du site. l’utilisateur peut accéder à certaines parties du site internet même s’il ne souhaite pas que des cookies soient créés. Il est toutefois à noter que certaines fonctions peuvent être limitées.</p><p>la plupart des navigateurs acceptent les cookies automatiquement. L’utilisateur peut néanmoins empêcher leur création en configurant son navigateur pour qu’il bloque tous les cookies. Pour plus de détails, se reporter aux instructions fournies par le développeur du navigateur.</p><p>Pour plus d’informations sur les cookies, consulter le site de la cnil : http://www.cnil.fr/vos-droits/vos-traces/les-cookies.</p>',
                'pageId' => 12,
            ],
            ['title' => "Conditions générales de vente",
                'content' => '<ol><li><h2>GENERALITES</h2><p>Les présentes conditions générales s&apos;appliquent, sans restriction ni réserve, à l&apos;ensemble des prestations de services proposées par Sophie BOULANGÉ immatriculée sous le numéro SIREN 507 421 683 00024, et ce, à l&apos;ensemble de ses clients, quel que soit leur statut ou qualité. En conséquence, la passation d&apos;une commande par un client pour la réalisation d&apos;une prestation proposée emporte l&apos;adhésion de ces derniers et leur acceptation, sans réserve, aux présentes conditions générales sauf accord particulier préalablement convenu par écrit entre les parties.</p><p>Sophie BOULANGÉ  se réserve le droit de modifier à tout moment les présentes conditions générales, étant précisé que les modifications seront applicables aux seules commandes passées en suite de l&apos;entrée en vigueur desdites modifications.</p><p>Tout autre document que les présentes conditions générales et notamment les publicités, prospectus, flyers...n&apos;a qu&apos;une valeur informative de l&apos;activité proposée par Sophie Boulangé et est non contractuel.</p></li><li><h2>CARACTERISTIQUES GENERALES DES PRESTATIONS</h2><p>Sophie BOULANGÉ s&apos;engage à :<ul><li>Effectuer ses prestations dans le respect total de l&apos;intégrité physique et morale du client</li><li>Respecter une stricte confidentialité</li><li>Garantir une prestation optimale, notamment en maintenant ses compétences au plus haut niveau à l&apos;aide de cours, de stages et formations complémentaires</li></ul><p>La finalité de l&apos;activité de Sophie BOULANGÉ est exclusivement le bien-être de la personne. Conformément à la législation en vigueur, les massages bien-être pratiqués en l&apos;absence de diagnostic et de traitement thérapeutique, ne s&apos;apparentent en rien, ni dans les contenus ni dans les objectifs, à la pratique de la masso-kinésithérapie, ainsi qu&apos;à toute pratique médicale thérapeutique. Il s&apos;agit de techniques manuelles de bien-être et de relaxation uniquement. Sont également exclues , toutes prestations à caractère érotique ou sexuel. Tout comportement déplacé envers ses prestataires pourra faire l&apos;objet de poursuite judiciaire.</p></li><li><h2>CONDITIONS DE REALISATION DES PRESTATIONS</h2><p>En effet, à la lecture des présentes conditions générales, le client est informé et accepte qu&apos;il est contre-indiqué de donner un massage de bien-être, sans avis médical préalable, à des personnes souffrant, sans que cette liste soit exhaustive, de pathologies lourdes (problèmes cardiaque, insuffisance rénale, cancer,...), de troubles nerveux (épilepsie, ...), de diabète important.</p><p>Il existe des contre-indications absolues : phlébite (même récente), forte fièvre, sur un fibrome ou une tumeur, lors d&apos;une chimiothérapie, à la suite d&apos;une intervention chirurgicale majeure.</p><p>Enfin, il existe des restrictions relatives au massage dans les cas suivants (les zones concernées étant proscrites): blessure (inflammation aigüe, déchirure musculaire, cicatrice récente ou douloureuse, plaie), trouble circulatoire important, tendinite ou luxation, hernie discale, crise aigüe d&apos;arthrose ou d&apos;arthrite, hématomes, affections cutanées couvrantes (œdème, dermatose, eczéma infecté) ou contagieuses.</p><p>En cas d&apos;allergies, le client s&apos;engage à en informer  Sophie BOULANGÉ au moment de la prise de rendez-vous.</p><p>Pour s&apos;assurer que leur client est apte à recevoir un massage bien-être, Sophie BOULANGÉ lui feront signer un document rappelant les contre-indications susvisées lors du premier rendez-vous. Le client attestera également par sa signature qu&apos;il n&apos;a rien à déclarer sur son état de santé qui ne serait pas compatible avec la réalisation d&apos;un massage bien-être sur sa personne sans avis médical et déclare informer au préalable Sophie BOULANGÉ de tous changements sur son état de santé lors des prochains rendez-vous.</p><p>En conséquence, Sophie BOULANGÉ  se réserve le droit de refuser à tout moment, un client dont l&apos;état de santé ne serait pas compatible avec la réalisation d&apos;un massage bien-être sur sa personne sans avis médical préalable.</p><p>Le client s&apos;engage à respecter les règles élémentaires d&apos;hygiène corporelle et à prendre une douche avant tout début de prestation.</p><p>De même, les séances de massages ne seront proposées qu&apos;aux personnes majeures, ou mineures titulaires d&apos;une autorisation de son représentant légal à la pratique du massage bien-être.</p></li><li><h2>DISCIPLINE :</h2><p>Gestion des retards - La prise de rendez-vous par  Sophie BOULANGÉ est réalisée de façon à ne pas avoir de retard. Un temps est prévu entre chaque massage ce qui permet d&apos;accueillir le client suivant dans les meilleures conditions possibles. Il est donc demandé au client d&apos;arriver à l&apos;heure indiquée lors de la prise de rendez-vous. Si le client arrive en retard, la séance sera peut-être écourtée.</p></li><li><h2>CONDITIONS FINANCIERES</h2><p>Les prix sont entendus en Euros, toutes taxes comprises. Les prix sont fermes, sans escompte, ni rabais, ni ristourne.</p><p>Sophie BOULANGÉ  se réserve également le droit de modifier ses prix à tout moment, étant précisé que les prestations seront facturées sur la base des tarifs en vigueur au moment de la réservation du rendez-vous.</p><p>Le paiement de la prestation devra se faire par carte bancaire, virement, chèque ou espèces au début du rendez-vous.</p><p>Pour les prestations nécessitant un devis personnalisé (évènementiels, salons, congrès,...) : Le devis est valable un mois à partir de la date d&apos;émission de celui-ci.</p><p>Le devis et les CGV signés par le client valent pour accord et bon de commande. Le devis et les CGV signés doivent être accompagnés d&apos;un versement de 30% du montant total indiqué sur le devis. Le versement de cet acompte se fera par carte bancaire, virement, chèque ou espèces.</p><p>Le solde du paiement s&apos;effectue au comptant à la date d&apos;émission de la facture, par carte bancaire, virement, chèque ou espèces. En cas de retard de paiement, une pénalité fixée à 15% du montant de la facture, par mois de retard entamé, est exigible sans qu&apos;un rappel ne soit nécessaire, dès le jour suivant la date limite de règlement.</p><p>En cas d&apos;annulation à l&apos;initiative de Sophie BOULANGÉ , et si aucune date de remplacement n&apos;est convenue, celle-ci remboursera au client l&apos;acompte perçu dans un délai maximal de 8 (huit) jours.</p><p>En cas d&apos;annulation de rendez-vous de la part du client, celui-ci devra le faire par mail au moins 24h avant ce dernier. Tout rendez-vous non annulé dans ce délai pourra faire l&apos;objet d&apos;une facturation.</p></li><li><h2>INCAPACITE DE TRAVAIL</h2><p>En cas d&apos;incapacité physique temporaire, par suite de maladie ou d&apos;accident, une nouvelle date d&apos;interventions en concertation avec le client sera planifiée sans qu&apos;il ne puisse être exigé par ce dernier de versement d&apos;indemnité. En cas d&apos;incapacité physique permanente, tout type de contrat ou d&apos;engagement avec les clients seront résiliés de plein droit sans qu&apos;il ne puisse être réclamé une indemnité compensatrice. Les acomptes perçus seront restitués au client dans un délai maximal de 8 (huit) jours suivant la résiliation du contrat.</p></li><li><h2>LOI APPLICABLE ET JURIDICTION COMPETENTE</h2><p>Les présentes CGV sont soumises à la législation française. En cas de litiges les parties s&apos;engagent à rechercher une solution à l&apos;amiable avant toute action judiciaire. A défaut, tout différent survenant avec un client ayant la qualité de commerçant et qui serait lié à l&apos;interprétation, l&apos;exécution ou la validité des présentes CGV sera soumis à la compétence exclusive des tribunaux de NANCY. Pour l&apos;ensemble des autres clients, ce sont les dispositions du code de procédure civile qui s&apos;appliqueront.</p><li><h2>RESPONSABILITE CIVILE PROFESSIONNELLE</h2><p>Sophie BOULANGÉ a  souscrit auprès d&apos;une compagnie d&apos;assurance, un contrat de responsabilité civile professionnelle.</p><p>Il est précisé que la responsabilité Sophie BOULANGÉ ne saurait être engagée en cas de dommages liés à la négligence d&apos;un client, en particulier s&apos;il n&apos;a pas révélé à Sophie BOULANGÉ l&apos;existence de contre-indications l&apos;affectant, que ce soit lors de la signature du document d&apos;information visant à l&apos;alerter des contre-indications applicables, ou des rendez-vous ultérieurs en cas de modifications de son état de santé personnel.</p></li></ol><p>Date d&apos;entrée en vigueur : 01/08/2019</p>',
                'pageId' => 13,
            ],
        ];

        foreach($articles as $article) {
            $this->addSql('INSERT INTO article (title, content, page_id) VALUES (:title, :content, :pageId)', $article);
        }

    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE action_container DROP FOREIGN KEY FK_63A4FF06BC21F742');
        $this->addSql('DROP TABLE container');
        $this->addSql('DROP TABLE action_container');
    }
}
