#ifndef PRINCIPALE_H
#define PRINCIPALE_H

#include <QMainWindow>
#include <QSqlDatabase>
namespace Ui {
    class Principale;
}
/*!
 *  \property  Principale
 *  \brief     Classe mère.
 *  \details   Permet de gérer les méthodes de l'application,manipule l'interface graphique de l'application.
 *  \author    Lampson Peter
 *  \version   2.2
 *  \date      12/12/13
 *  \sa dialogconnection.h
 *  \copyright GNU Public License.
 */
class Principale : public QMainWindow {
    Q_OBJECT
public:
    /*!
     * \brief Contructeur
     * \relates Principale
     * \param QWidget *parent
     * \return Ne renvoi rien du tout.
     */
    Principale(QWidget *parent = 0);
    ~Principale();
    //Chargement des comboBox--//
  /*  /*!
     * \brief Chargement des dépots légaux
     * \details Charge la liste des dépots légaux des médicaments dans l'onglet "Gestion Medicaments".
     * \return Ne retourne rien du tout
     * \relates Principale
     */
    //void ChargeListMed_Depot();*/
    /*!
     * \brief Chargement des laboratoires
     * \details Cette procédure charge la liste des laboratoires dans le formulaire d'ajout dans l'onglet "Gestion Visiteur".
     * \return Ne retourne rien du tout
     * \relates Principale
     */
    void ChargeLabo_Vis_Ajout();

    /*!
     * \brief Chargement des matricules des visiteurs
     * \details Cette procédure charge les  matricules des visiteurs dans le formulaire de modification dans l'onglet "Gestion Visiteur".
     * \return Ne retourne rien du tout
     * \relates Principale
     */
    void chargeListVis();

    /*!
     * \brief Chargement des code de Praticiens
     * \details Charge la liste des codes de praticiens dans l'onglet "Gestion Praticiens".
     * \return Ne retourne rien du tout
     * \relates Principale
     */
    void ChargeListPrat_Num_Mod();
    /*!
     * \brief Chargement des méthodes du praticiens
     * \details Charge la liste des méthodes possible du praticiens lors de l'ajout de celui-ci dans la base dans l'onglet "Gestion Praticien".
     * \return Ne retourne rien du tout
     * \relates Principale
     */
    void ChargeFonction_Prat_Ajout();

    /*!
     * \brief Chargement des familles de médicaments
     * \details Charge la liste des familles des médicaments dans l'onglet "Gestion Medicament".
     * \return Ne retourne rien du tout
     * \relates Principale
     */
    void chargeListFamille();
    //-------------------------//
protected:
    void changeEvent(QEvent *e);

private slots:


    /*!
     * \brief Chargement des informations du praticien
     * \details Cette méthode charge les informations du praticiens selectionné dans la liste déroulante dans les champs du formulaire de modification dans l'onglet "Gestion Praticien"
     * \return Ne retourne rien du tout
     * \relates Principale
     */
    void on_comboBox_Prat_Num_Mod_currentIndexChanged();

    /*!
     * \brief Ajout d'un praticien
     * \details Cette méthode ajoute un praticien dans la base avec les informations saisient dans le formulaire dans l'onglet 'Gestion Praticien'.
     * \return Ne retourne rien du tout
     * \relates Principale
     */
    void on_pushButton_Prat_Ajout_clicked();

    /*!
     * \brief Suppression d'un praticien
     * \details Cette méthode supprime le praticien saisi de la base de données dans l'onglet "Gestion Praticien".
     * \warning La suppression d'un praticien est definitive .
     * \return Ne retourne rien du tout
     * \relates Principale
     */
    void on_pushButton_Prat_Suppr_clicked();

    /*!
     * \brief Modification d'un praticien
     * \details Cette méthode permet de modifier les informations d'un praticien dans l'onglet "Gestion Praticien"
     * \return Ne retourne rien du tout
     * \relates Principale
     */
    void on_pushButton_Prat_Mod_clicked();

    /*!
     * \brief Chargement des dépot légaux des médicaments
     * \details Cette méthode insere le nom des dépôts légaux selon la famille choisie dans l'onglet "Gestion Medicament".
     * \return Ne retourne rien du tout
     * \relates Principale
     */
    void on_comboBox_Med_Famille_Mod_currentIndexChanged();

    /*!
     * \brief Chargement des informations du médicament
     * \details Cette méthode charge les informations du médicament selectionné dans la liste déroulante dans les champs du formulaire de modification dans l'onglet "Gestion Medicament".
     * \return Ne retourne rien du tout
     * \relates Principale
     */
    void on_comboBox_Med_DepotLegal_Mod_currentIndexChanged();

    /*!
     * \brief Ajout d'un médicament
     * \details Cette méthode ajoute un médicament dans la base avec les informations saisient dans le formulaire dans l'onglet "Gestion Medicament".
     * \return Ne retourne rien du tout
     * \relates Principale
     */
    void on_pushButton_Med_Ajout_clicked();

    /*!
     * \brief Modification d'un médicament
     * \details Cette méthode permet de modifier les informations d'un médicament dans l'onglet "Gestion Medicament"
     * \return Ne retourne rien du tout
     * \relates Principale
     */
    void on_pushButton_Med_Mod_clicked();

    /*!
     * \brief Suppression d'un médicament
     * \details Cette méthode supprime le médicament saisi de la base de données dans l'onglet 'Gestion Medicament'.
     * \warning La suppression d'un médicament est definitive .
     * \return Ne retourne rien du tout
     * \relates Principale
     */
    void on_pushButton_Med_Supr_clicked();

    /*!
     * \brief Ajout d'un visiteur
     * \details Cette méthode ajoute un visiteur dans la base avec les informations saisient dans le formulaire dans l'onglet 'Gestion Visiteur'.
     * \return Ne retourne rien du tout
     * \relates Principale
     */
    void on_pushButton_Vis_Ajouter_clicked();

    /*!
     * \brief Chargement des informations du visiteur
     * \details Cette méthode charge les informations du visiteur selectionné dans la liste déroulante dans les champs du formulaire de modification dans l'onglet "Gestion Visiteur".
     * \return Ne retourne rien du tout
     * \relates Principale
     */
    void on_comboBox_Vis_Mat_Mod_currentIndexChanged();

    /*!
     * \brief Modification d'un visiteur
     * \details Cette méthode permet de modifier les informations d'un visiteur dans l'onglet "Gestion Visiteur"
     * \return Ne retourne rien du tout
     * \relates Principale
     */
    void on_pushButton_Vis_Mod_clicked();
    /*!
     * \brief Suppression d'un visiteur
     * \details Cette méthode supprime le visiteur saisi de la base de données dans l'onglet 'Gestion Visiteur'.
     * \warning La suppression d'un visiteur est definitive (tout les rapports liant ce visiteur seront aussi supprimés).
     * \return Ne retourne rien du tout
     * \relates Principale
     */
    void on_pushButton_Vis_Supr_clicked();

private:
    Ui::Principale *ui;

};

#endif // PRINCIPALE_H
