#include "dialogconnection.h"
#include "ui_dialogconnection.h"
#include "QString"
#include "QSqlQuery"
#include "QDebug"
DialogConnection::DialogConnection(QWidget *parent) :
    QDialog(parent),
    ui(new Ui::DialogConnection)
{
    ui->setupUi(this);
}

DialogConnection::~DialogConnection()
{
    delete ui;
}

void DialogConnection::changeEvent(QEvent *e)
{
    QDialog::changeEvent(e);
    switch (e->type()) {
    case QEvent::LanguageChange:
        ui->retranslateUi(this);
        break;
    default:
        break;
    }
}

void DialogConnection::on_buttonBox_Connect_accepted()
{
QString chRequete="select count(*) from travailler where VIS_MATRICULE='"+ui->lineEdit_Matricule->text()+"' and JJMMAA='"+ui->lineEdit_Password->text()+"';";
qDebug()<<chRequete;
QSqlQuery requete(chRequete);
requete.first();
if(requete.value(0) == 1)
{
     qDebug("Login et password existant");
     requete.exec("select JJMMAA, TRA_ROLE from travailler where TRA_ROLE!='Visiteur' AND VIS_MATRICULE='"+ui->lineEdit_Matricule->text()+"' AND JJMMAA='"+ui->lineEdit_Password->text()+"' group by VIS_MATRICULE having JJMMAA=MAX(JJMMAA);");
  //  requete.first();
    qDebug()<<requete.value(0).toString()+" test";
    if(requete.first())
            {
        qDebug()<<"Connexion reussi";
            accept();
    }
   else
    {
        qDebug("Mais vous ne possedez pas l'autorisation d'utiliser cette application, veuillez contacter votre chef de service ou l'administrateur");
        reject();
    }


}
else
{
    qDebug("Login et password inexistant");
    reject();
}

//fin void
}

void DialogConnection::on_buttonBox_Connect_rejected()
{
      reject();
}
