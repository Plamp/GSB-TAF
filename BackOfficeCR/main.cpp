class Principal;
#include <QApplication>
#include "principale.h"
#include "dialogconnection.h"
#include "QMessageBox"
#include "QTextCodec"
int main(int argc, char *argv[])
{
    //prise en compte de l'utf8

      QApplication a(argc, argv);
   QSqlDatabase db= QSqlDatabase::addDatabase("QMYSQL");
db.setHostName("LocalHost");
db.setUserName("root");// crÃ©e un utilisateur plutot que root
db.setPassword("");
db.setDatabaseName("db_gestioncr");
if(!db.open())
{
qDebug("Le serveur de base de données est inexistant.Merci de contacter l'administrateur et de relancer l'application");
}
else
{
qDebug("connection reussi");
}

    DialogConnection d;
    if(d.exec()==QDialog::Accepted)
    {

    Principale w;
    w.show();
    return a.exec();
    }
    else
    {
    return 0;
    }
}
