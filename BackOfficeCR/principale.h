#ifndef PRINCIPALE_H
#define PRINCIPALE_H

#include <QMainWindow>
#include <QSqlDatabase>
namespace Ui {
    class Principale;
}
/*!
 *  \property  Principale
 *  \brief     Classe m�re.
 *  \details   Permet de g�rer les m�thodes de l'application,manipule l'interface graphique de l'application.
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
     * \brief Chargement des d�pots l�gaux
     * \details Charge la liste des d�pots l�gaux des m�dicaments dans l'onglet "Gestion Medicaments".
     * \return Ne retourne rien du tout
     * \relates Principale
     */
    //void ChargeListMed_Depot();*/
    /*!
     * \brief Chargement des laboratoires
     * \details Cette proc�dure charge la liste des laboratoires dans le formulaire d'ajout dans l'onglet "Gestion Visiteur".
     * \return Ne retourne rien du tout
     * \relates Principale
     */
    void ChargeLabo_Vis_Ajout();

    /*!
     * \brief Chargement des matricules des visiteurs
     * \details Cette proc�dure charge les  matricules des visiteurs dans le formulaire de modification dans l'onglet "Gestion Visiteur".
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
     * \brief Chargement des m�thodes du praticiens
     * \details Charge la liste des m�thodes possible du praticiens lors de l'ajout de celui-ci dans la base dans l'onglet "Gestion Praticien".
     * \return Ne retourne rien du tout
     * \relates Principale
     */
    void ChargeFonction_Prat_Ajout();

    /*!
     * \brief Chargement des familles de m�dicaments
     * \details Charge la liste des familles des m�dicaments dans l'onglet "Gestion Medicament".
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
     * \details Cette m�thode charge les informations du praticiens selectionn� dans la liste d�roulante dans les champs du formulaire de modification dans l'onglet "Gestion Praticien"
     * \return Ne retourne rien du tout
     * \relates Principale
     */
    void on_comboBox_Prat_Num_Mod_currentIndexChanged();

    /*!
     * \brief Ajout d'un praticien
     * \details Cette m�thode ajoute un praticien dans la base avec les informations saisient dans le formulaire dans l'onglet 'Gestion Praticien'.
     * \return Ne retourne rien du tout
     * \relates Principale
     */
    void on_pushButton_Prat_Ajout_clicked();

    /*!
     * \brief Suppression d'un praticien
     * \details Cette m�thode supprime le praticien saisi de la base de donn�es dans l'onglet "Gestion Praticien".
     * \warning La suppression d'un praticien est definitive .
     * \return Ne retourne rien du tout
     * \relates Principale
     */
    void on_pushButton_Prat_Suppr_clicked();

    /*!
     * \brief Modification d'un praticien
     * \details Cette m�thode permet de modifier les informations d'un praticien dans l'onglet "Gestion Praticien"
     * \return Ne retourne rien du tout
     * \relates Principale
     */
    void on_pushButton_Prat_Mod_clicked();

    /*!
     * \brief Chargement des d�pot l�gaux des m�dicaments
     * \details Cette m�thode insere le nom des d�p�ts l�gaux selon la famille choisie dans l'onglet "Gestion Medicament".
     * \return Ne retourne rien du tout
     * \relates Principale
     */
    void on_comboBox_Med_Famille_Mod_currentIndexChanged();

    /*!
     * \brief Chargement des informations du m�dicament
     * \details Cette m�thode charge les informations du m�dicament selectionn� dans la liste d�roulante dans les champs du formulaire de modification dans l'onglet "Gestion Medicament".
     * \return Ne retourne rien du tout
     * \relates Principale
     */
    void on_comboBox_Med_DepotLegal_Mod_currentIndexChanged();

    /*!
     * \brief Ajout d'un m�dicament
     * \details Cette m�thode ajoute un m�dicament dans la base avec les informations saisient dans le formulaire dans l'onglet "Gestion Medicament".
     * \return Ne retourne rien du tout
     * \relates Principale
     */
    void on_pushButton_Med_Ajout_clicked();

    /*!
     * \brief Modification d'un m�dicament
     * \details Cette m�thode permet de modifier les informations d'un m�dicament dans l'onglet "Gestion Medicament"
     * \return Ne retourne rien du tout
     * \relates Principale
     */
    void on_pushButton_Med_Mod_clicked();

    /*!
     * \brief Suppression d'un m�dicament
     * \details Cette m�thode supprime le m�dicament saisi de la base de donn�es dans l'onglet 'Gestion Medicament'.
     * \warning La suppression d'un m�dicament est definitive .
     * \return Ne retourne rien du tout
     * \relates Principale
     */
    void on_pushButton_Med_Supr_clicked();

    /*!
     * \brief Ajout d'un visiteur
     * \details Cette m�thode ajoute un visiteur dans la base avec les informations saisient dans le formulaire dans l'onglet 'Gestion Visiteur'.
     * \return Ne retourne rien du tout
     * \relates Principale
     */
    void on_pushButton_Vis_Ajouter_clicked();

    /*!
     * \brief Chargement des informations du visiteur
     * \details Cette m�thode charge les informations du visiteur selectionn� dans la liste d�roulante dans les champs du formulaire de modification dans l'onglet "Gestion Visiteur".
     * \return Ne retourne rien du tout
     * \relates Principale
     */
    void on_comboBox_Vis_Mat_Mod_currentIndexChanged();

    /*!
     * \brief Modification d'un visiteur
     * \details Cette m�thode permet de modifier les informations d'un visiteur dans l'onglet "Gestion Visiteur"
     * \return Ne retourne rien du tout
     * \relates Principale
     */
    void on_pushButton_Vis_Mod_clicked();
    /*!
     * \brief Suppression d'un visiteur
     * \details Cette m�thode supprime le visiteur saisi de la base de donn�es dans l'onglet 'Gestion Visiteur'.
     * \warning La suppression d'un visiteur est definitive (tout les rapports liant ce visiteur seront aussi supprim�s).
     * \return Ne retourne rien du tout
     * \relates Principale
     */
    void on_pushButton_Vis_Supr_clicked();

private:
    Ui::Principale *ui;

};

#endif // PRINCIPALE_H
