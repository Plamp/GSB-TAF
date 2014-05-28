#ifndef DIALOGCONNECTION_H
#define DIALOGCONNECTION_H

#include <QDialog>

namespace Ui {
    class DialogConnection;
}
/*!
 *  \property  DialogConnection
 *  \brief     Classe secondaire.
 *  \details   Permet de gérer la connection des utilisateurs.
 *  \author    Lampson Peter
 *  \date      12/12/13
 *  \copyright GNU Public License.
 */
class DialogConnection : public QDialog {
    Q_OBJECT
public:
    /*!
     * \brief Contructeur
     * \relates DialogConnection
     * \param QWidget *parent
     * \return Ne renvoi rien du tout.
     */
    DialogConnection(QWidget *parent = 0);
    ~DialogConnection();

protected:
    void changeEvent(QEvent *e);

private:
    Ui::DialogConnection *ui;

private slots:
    /*!
     * \brief Annulation de la connection
     * \details Lors du clic sur le bouton "Annuler", cela quitte l'application.
     * \relates DialogConnection
     * \return reject().
     */
    void on_buttonBox_Connect_rejected();

    /*!
     * \brief Tentative de condition
     * \details Lors du clic sur "Ok" cette méthode verifi si les identifiants sont corrects et que l'utilisateur a le droit d'utiliser l'application.
     * \relates DialogConnection
     * \return accept() si les conditions sont remplies reject() sinon.
     */
    void on_buttonBox_Connect_accepted();
};

#endif // DIALOGCONNECTION_H
