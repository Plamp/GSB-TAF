#include "principale.h"
#include "ui_principale.h"
#include "QSqlDatabase"
#include "QMessageBox"
#include "QString"
#include "QSqlQuery"
#include "QDebug"
#include "QStatusBar"
#include "QTextCodec"
Principale::Principale(QWidget *parent) :
    QMainWindow(parent),
    ui(new Ui::Principale)
{
    ui->setupUi(this);
    this->chargeListFamille();
    this->ChargeListPrat_Num_Mod();
    this->ChargeFonction_Prat_Ajout();
    this->ChargeLabo_Vis_Ajout();
    this->chargeListVis();
}

Principale::~Principale()
{
    delete ui;
}

void Principale::changeEvent(QEvent *e)
{
    QMainWindow::changeEvent(e);
    switch (e->type()) {
    case QEvent::LanguageChange:
        ui->retranslateUi(this);
        break;
    default:
        break;
    }
}
void Principale::chargeListFamille()
{
    QSqlQuery Result;
    Result.exec("Select FAM_LIBELLE from FAMILLE ;");
    ui->comboBox_Med_Famille_Mod->clear();
    ui->comboBox_Med_Famille_Ajout->clear();
    while(Result.next())
    {
        ui->comboBox_Med_Famille_Mod->addItem(Result.value(0).toString());
        ui->comboBox_Med_Famille_Ajout->addItem(Result.value(0).toString());
    }
}
/*
void Principale::ChargeListMed_Depot()
{
    QString Req="Select MED_DEPOTLEGAL from MEDICAMENT";
    QSqlQuery Result;
    Result.exec(Req);
    int i=0;
    while (Result.next())
    {
        ui->comboBox_Med_DepotLegal_Mod->addItem(Result.value(0).toString(),i);
        i++;
    }
}*/
void Principale::ChargeListPrat_Num_Mod()
{
    QString Req="Select PRA_CODE,PRA_NOM from PRATICIEN";
    QSqlQuery Result;
    ui->comboBox_Prat_Num_Mod->clear();
    Result.exec(Req);
    while (Result.next())
    {
        ui->comboBox_Prat_Num_Mod->addItem(Result.value(0).toString()+" "+Result.value(1).toString());


    }
}
void Principale::ChargeFonction_Prat_Ajout()
{
    QSqlQuery Result;
    Result.exec("select TYP_LIBELLE from TYPE_PRATICIEN");
    ui->comboBox_Prat_Fonction_Ajout->clear();
    while(Result.next())
    {
        ui->comboBox_Prat_Fonction_Ajout->addItem(Result.value(0).toString());
    }
}
void Principale::ChargeLabo_Vis_Ajout()
{
    ui->comboBox_Vis_Labo_Ajout->clear();
    QSqlQuery req;
    req.exec("Select LAB_NOM from LABO ;");
    while (req.next())
    {
        ui->comboBox_Vis_Labo_Ajout->addItem(req.value(0).toString());
    }
}
void Principale::chargeListVis()
{
    ui->comboBox_Vis_Mat_Mod->clear();
    QSqlQuery req;
    req.exec("select VIS_MATRICULE,VIS_NOM from VISITEUR ;");
    while(req.next())
    {
        ui->comboBox_Vis_Mat_Mod->addItem(req.value(0).toString()+" "+req.value(1).toString());
    }

}

void Principale::on_comboBox_Prat_Num_Mod_currentIndexChanged()
{
    //recuperation du numéro avant la modification

    QStringList recupNom=ui->comboBox_Prat_Num_Mod->currentText().split(" ");
    QString num=recupNom[0];

    //On recupere les info du praticien

    QString reqNum="Select PRA_NOM,PRA_PRENOM,PRA_ADRESSE,PRA_CP,PRA_VILLE,PRA_COEFNOTORIETE,TYP_LIBELLE from PRATICIEN natural join TYPE_PRATICIEN where PRA_CODE="+num+"";
    QSqlQuery resultNum(reqNum);
    resultNum.first();
    ui->lineEdit_Prat_Nom_Mod->setText(resultNum.value(0).toString());
    ui->lineEdit_Prat_Prenom_Mod->setText(resultNum.value(1).toString());
    ui->lineEdit_Prat_Adresse_Mod->setText(resultNum.value(2).toString());
    ui->lineEdit_Prat_CP_Mod->setText(resultNum.value(3).toString());
    ui->lineEdit_Prat_Ville_Mod->setText(resultNum.value(4).toString());
    ui->lineEdit_Prat_coeff_Mod->setText(resultNum.value(5).toString());
    // ajouter un clear dans la comboBox
    ui->comboBox_Prat_Fonction_Mod->clear();
    ui->comboBox_Prat_Fonction_Mod->addItem(resultNum.value(6).toString(),0);
    //Chargement de la liste déroulante fonction

    QString reqFonc="select TYP_LIBELLE from TYPE_PRATICIEN where TYP_LIBELLE!='"+resultNum.value(6).toString()+"'";
    QSqlQuery resultFonc(reqFonc);
    int i=1;
    while(resultFonc.next())
    {
        ui->comboBox_Prat_Fonction_Mod->addItem(resultFonc.value(0).toString(),i);
        i++;
    }

}

void Principale::on_pushButton_Prat_Ajout_clicked()
{
    //recuperation des info du Prat
    QString nom=ui->lineEdit_Prat_Nom_Ajout->text();
    QString prenom=ui->lineEdit_Prat_Prenom_Ajout->text();
    QString ville=ui->lineEdit_Prat_Ville_Ajout->text();
    QString coeff=ui->lineEdit_Prat_Coefficient_Ajout->text();
    QString cp=ui->lineEdit_Prat_CP_Ajout->text();
    QString adresse=ui->lineEdit_Prat_Adresse_Ajout->text();
    QString fonction=ui->comboBox_Prat_Fonction_Ajout->currentText();
    //recuperation du numero du Prat
    QSqlQuery result_num_Prat;
    result_num_Prat.exec("select (MAX(PRA_CODE)+1) from PRATICIEN ;");
    result_num_Prat.first();
    QString code=result_num_Prat.value(0).toString();
    //recuperation du numero de fonction
    QSqlQuery result_num_Fonction;
    result_num_Fonction.exec("select TYP_CODE from TYPE_PRATICIEN where TYP_LIBELLE='"+fonction+"';");
    result_num_Fonction.first();
    QString num_Fonction=result_num_Fonction.value(0).toString();
    //insertion du praticien dans la base
    QSqlQuery insert_Prat;
    insert_Prat.exec("insert into PRATICIEN(PRA_CODE,PRA_NOM,PRA_PRENOM,PRA_ADRESSE,PRA_CP,PRA_VILLE,PRA_COEFNOTORIETE,TYP_CODE) values ("+code+",'"+nom+"','"+prenom+"','"+adresse+"','"+cp+"','"+ville+"',"+coeff+",'"+num_Fonction+"');");
    insert_Prat.first();
    //  qDebug()<<"insert into PRATICIEN(PRA_CODE,PRA_NOM,PRA_PRENOM,PRA_ADRESSE,PRA_CP,PRA_VILLE,PRA_COEFNOTORIETE,TYP_CODE) values ("+code+",'"+nom+"','"+prenom+"','"+adresse+"','"+cp+"',"+ville+"',"+coeff+",'"+num_Fonction+"');";
    this->ChargeListPrat_Num_Mod();
        statusBar()->showMessage("Ajout effectue");
}

void Principale::on_pushButton_Prat_Suppr_clicked()
{
    //recuperation du num�ro avant la modification

    QStringList recupNum=ui->comboBox_Prat_Num_Mod->currentText().split(" ");
    QString num=recupNum[0];
    QSqlQuery result;
    result.exec("delete from RAPPORT_VISITE where PRA_CODE="+num+";");
    result.exec("delete from POSSEDER where PRA_CODE="+num+";");
    result.exec("delete from INVITER where PRA_CODE="+num+";");
    result.exec("delete from PRATICIEN where PRA_CODE="+num+";");
    result.first();
 statusBar()->showMessage("Suppression effectuee");
    this->ChargeListPrat_Num_Mod();
}

void Principale::on_pushButton_Prat_Mod_clicked()
{
    //recuperation du num�ro avant la modification
    QStringList recupNum=ui->comboBox_Prat_Num_Mod->currentText().split(" ");
    QString num=recupNum[0];

    QString nom=ui->lineEdit_Prat_Nom_Mod->text();
    QString prenom=ui->lineEdit_Prat_Prenom_Mod->text();
    QString adresse=ui->lineEdit_Prat_Adresse_Mod->text();
    QString cp=ui->lineEdit_Prat_CP_Mod->text();
    QString fonction=ui->comboBox_Prat_Fonction_Mod->currentText();
    QString coeff=ui->lineEdit_Prat_coeff_Mod->text();

    //recuperation du numero de fonction
    QSqlQuery result_num_Fonction;
    result_num_Fonction.exec("select TYP_CODE from TYPE_PRATICIEN where TYP_LIBELLE='"+fonction+"';");
    result_num_Fonction.first();
    QString num_Fonction=result_num_Fonction.value(0).toString();
    //Modification du praticien
    QSqlQuery update_Prat;
    update_Prat.exec("update PRATICIEN set PRA_NOM='"+nom+"',PRA_PRENOM='"+prenom+"',PRA_ADRESSE='"+adresse+"',PRA_CP='"+cp+"',PRA_COEFNOTORIETE="+coeff+",TYP_CODE='"+num_Fonction+"' where PRA_CODE='"+num+"';");
    update_Prat.first();
    //  qDebug()<<"update PRATICIEN set PRA_NOM='"+nom+"',PRA_PRENOM='"+prenom+"',PRA_ADRESSE='"+adresse+"',PRA_CP='"+cp+"',PRA_COEFNOTORIETE="+coeff+",TYP_CODE='"+num_Fonction+"' where PRA_CODE='"+num+"';";
    statusBar()->showMessage("Modification effectuee");
     this->ChargeListPrat_Num_Mod();
    ui->comboBox_Prat_Num_Mod->setCurrentIndex(ui->comboBox_Prat_Num_Mod->currentIndex());
}

void Principale::on_comboBox_Med_Famille_Mod_currentIndexChanged()
{
    QString famille=ui->comboBox_Med_Famille_Mod->currentText();
    //recuperation du code Famille du medicament
    QSqlQuery ResultFam;
    ResultFam.exec("select FAM_CODE from FAMILLE where FAM_LIBELLE='"+famille+"';");
    ResultFam.first();
    QString codeFam=ResultFam.value(0).toString();
    //affichage des medicament selon la famille
    ui->comboBox_Med_DepotLegal_Mod->clear();
    QSqlQuery ResultMed;
    ResultMed.exec("select MED_DEPOTLEGAL from MEDICAMENT where FAM_CODE='"+codeFam+"';");
    qDebug()<<"select MED_DEPOTLEGAL from MEDICAMENT where FAM_CODE='"+codeFam+"';";
    while(ResultMed.next())
    {
        ui->comboBox_Med_DepotLegal_Mod->addItem(ResultMed.value(0).toString());
    }

}

void Principale::on_comboBox_Med_DepotLegal_Mod_currentIndexChanged()
{
    QString depotLegal=ui->comboBox_Med_DepotLegal_Mod->currentText();
    QSqlQuery req;
    req.exec("select MED_NOMCOMMERCIAL,MED_COMPOSITION,MED_EFFETS,MED_CONTREINDIC,MED_PRIXECHANTILLON from MEDICAMENT where MED_DEPOTLEGAL='"+depotLegal+"';");
    req.first();
    ui->lineEdit_Med_NomCom_Mod->setText(req.value(0).toString());
    ui->lineEdit_Med_Prix_Mod->setText(req.value(4).toString());
    ui->textEdit_MED_Compo_Mod->setPlainText(req.value(1).toString());
    ui->textEdit_MED_CI_Mod->setPlainText(req.value(3).toString());
    ui->textEdit_MED_Effet_Mod->setPlainText(req.value(2).toString());
}

void Principale::on_pushButton_Med_Ajout_clicked()
{
    //recuperation des donn�e
    QString FamLib=ui->comboBox_Med_Famille_Ajout->currentText();
    QString nom=ui->lineEdit_Med_NomCom_Ajout->text();
    QString depot=ui->lineEdit_Med_DepotLegal_Ajout->text();
    QString prix=ui->lineEdit_Med_Prix_Ajout->text();
    QString CI=ui->textEdit_MED_CI_Ajout->toPlainText();
    QString effet=ui->textEdit_MED_Effet_Ajout->toPlainText();
    QString compo=ui->textEdit_MED_Compo_Ajout->toPlainText();
    //recuperation du code de la famille
    QSqlQuery req;
    req.exec("Select FAM_CODE from FAMILLE where FAM_LIBELLE='"+FamLib+"';");
    req.first();
    QString famCode=req.value(0).toString();
    //insertion des valeurs
    req.exec("insert into MEDICAMENT (MED_DEPOTLEGAL,MED_NOMCOMMERCIAL,FAM_CODE,MED_COMPOSITION,MED_EFFETS,MED_CONTREINDIC,MED_PRIXECHANTILLON) values('"+depot+"','"+nom.replace("'"," ")+"','"+famCode+"','"+compo.replace("'"," ")+"','"+effet.replace("'"," ")+"','"+CI.replace("'"," ")+"',"+prix+");");
    // qDebug()<<"insert into MEDICAMENT (MED_DEPOTLEGAL,MED_NOMCOMMERCIAL,FAM_CODE,MED_COMPOSITION,MED_EFFETS,MED_CONTREINDIC,MED_PRIXECHANTILLON) values('"+depot+"','"+nom+"','"+famCode+"','"+compo+"','"+effet+"','"+CI+"',"+prix+");";
    req.first();
        statusBar()->showMessage("Ajout effectue");
}

void Principale::on_pushButton_Med_Mod_clicked()
{
    QString depotLegal=ui->comboBox_Med_DepotLegal_Mod->currentText();
    QString nom=ui->lineEdit_Med_NomCom_Mod->text();
    QString  prix=ui->lineEdit_Med_Prix_Mod->text();
    QString   compo=ui->textEdit_MED_Compo_Mod->toPlainText();
    QString CI=ui->textEdit_MED_CI_Mod->toPlainText();
    QString  effet=ui->textEdit_MED_Effet_Mod->toPlainText();

    QSqlQuery req;
    req.exec("update MEDICAMENT set MED_NOMCOMMERCIAL='"+nom.replace("'"," ")+"',MED_COMPOSITION='"+compo.replace("'"," ")+"',MED_EFFETS='"+effet.replace("'"," ")+"',MED_CONTREINDIC='"+CI.replace("'"," ")+"',MED_PRIXECHANTILLON="+prix+" where MED_DEPOTLEGAL='"+depotLegal+"';");
       statusBar()->showMessage("Modification effectuee");
    // qDebug()<<"update MEDICAMENT set MED_NOMCOMMERCIAL='"+nom+"',MED_COMPOSITION='"+compo+"',MED_EFFETS='"+effet+"',MED_CONTREINDIC='"+CI+"',MED_PRIXECHANTILLON="+prix+" where MED_DEPOTLEGAL='"+depotLegal+"';";
}

void Principale::on_pushButton_Med_Supr_clicked()
{
    QString depotLegal=ui->comboBox_Med_DepotLegal_Mod->currentText();
    QSqlQuery req;

            req.exec("delete from PRESENTATION where MED_DEPOTLEGAL='"+depotLegal+"';");
        req.exec("delete from PRESCRIRE where MED_DEPOTLEGAL='"+depotLegal+"';");
        req.exec("delete from OFFRIR where MED_DEPOTLEGAL='"+depotLegal+"';");
        req.exec("delete from CONSTITUER where MED_DEPOTLEGAL='"+depotLegal+"';");
        req.exec("delete from FORMULER where MED_DEPOTLEGAL='"+depotLegal+"';");
    req.exec("delete from MEDICAMENT where MED_DEPOTLEGAL='"+depotLegal+"';");
    qDebug()<<"delete from MEDICAMENT where MED_DEPOTLEGAL='"+depotLegal+"';";
    int indexrecup=ui->comboBox_Med_Famille_Mod->currentIndex();
    this->chargeListFamille();
    ui->comboBox_Prat_Fonction_Mod->setCurrentIndex(indexrecup);
     statusBar()->showMessage("Suppression effectuee");
}

void Principale::on_pushButton_Vis_Ajouter_clicked()
{
    QString mat=ui->lineEdit_Vis_Mat_Ajout->text();
    QString nom=ui->lineEdit_Vis_Nom_Ajout->text();
    QString prenom=ui->lineEdit_Vis_Prenom_Ajout->text();
    QString adresse=ui->lineEdit_Vis_Adresse_Ajout->text();
    QString cp=ui->lineEdit_Vis_CP_Ajout->text();
    QString ville=ui->lineEdit_Vis_Ville_Ajout->text();
    QString sec=ui->lineEdit_Vis_Secteur_Ajout->text();
    QString laboLib=ui->comboBox_Vis_Labo_Ajout->currentText();
    QString dateEmbauche=ui->dateEdit->text() ;
    QString dep=cp.mid(0,2);
    qDebug()<<dep;
    //recuperation du code du LABO
    QSqlQuery req;
    req.exec("select LAB_CODE from LABO where LAB_NOM='"+laboLib+"';");
    req.first();
    QString labCod=req.value(0).toString();
    req.exec("insert into VISITEUR values('"+mat+"','"+nom+"','"+prenom+"','"+adresse+"','"+cp+"','"+ville+"','"+dateEmbauche+"','"+sec+"','"+labCod+"','"+dep+"',0);");
    qDebug()<<"insert into VISITEUR values('"+mat+"','"+nom+"','"+prenom+"','"+adresse+"','"+cp+"','"+ville+"','"+dateEmbauche+"','"+sec+"','"+labCod+"','"+dep+"',0);";
    this->chargeListVis();
        statusBar()->showMessage("Ajout effectue");

}

void Principale::on_comboBox_Vis_Mat_Mod_currentIndexChanged()
{
    ui->comboBox_Vis_Labo_Mod->clear();
    QStringList resultCombo=ui->comboBox_Vis_Mat_Mod->currentText().split(" ");
    QString mat=resultCombo[0];
    QSqlQuery req;
    req.exec("select * from VISITEUR where VIS_MATRICULE='"+mat+"';");
    // qDebug()<<"select * from VISITEUR where VIS_MATRICULE='"+mat+"';";
    req.first();
    ui->lineEdit_Vis_Nom_Mod->setText(req.value(1).toString());
    ui->lineEdit_Vis_Prenom_Mod->setText(req.value(2).toString());
    ui->lineEdit_Vis_Adresse_Mod->setText(req.value(3).toString());
    ui->lineEdit_Vis_CP_Mod->setText(req.value(4).toString());
    ui->lineEdit_Vis_Ville_Mod->setText(req.value(5).toString());
    ui->lineEdit_Vis_Secteur_Mod->setText(req.value(7).toString());

    //ajout des autres labo dans la liste
    QString labLib=req.value(8).toString();
    req.exec("select LAB_NOM from LABO where LAB_CODE='"+labLib+"';");
    //  qDebug()<<"select LAB_NOM from LABO where LAB_CODE='"+labLib+"';";
    req.first();
    ui->comboBox_Vis_Labo_Mod->addItem(req.value(0).toString());
    req.exec("select LAB_NOM from LABO where LAB_CODE!='"+labLib+"';");
    while(req.next())
    {
        ui->comboBox_Vis_Labo_Mod->addItem(req.value(0).toString());
    }


}

void Principale::on_pushButton_Vis_Mod_clicked()
{
    QStringList resultCombo=ui->comboBox_Vis_Mat_Mod->currentText().split(" ");
    QString mat=resultCombo[0];
    QSqlQuery req;
    QString nom=ui->lineEdit_Vis_Nom_Mod->text();
    QString prenom=ui->lineEdit_Vis_Prenom_Mod->text();
    QString cp=ui->lineEdit_Vis_CP_Mod->text();
    QString adresse=ui->lineEdit_Vis_Adresse_Mod->text();
    QString ville=ui->lineEdit_Vis_Ville_Mod->text();
    QString secCode=ui->lineEdit_Vis_Secteur_Mod->text();

    QString labLib=ui->comboBox_Vis_Labo_Mod->currentText();

    //r�cup�ration du code du labo depuis son libell�

    req.exec("select LAB_CODE from LABO where LAB_NOM='"+labLib+"';");
    req.first();
    QString labCode=req.value(0).toString();
    if (secCode==""){
        req.exec("update VISITEUR set VIS_NOM='"+nom+"',VIS_PRENOM='"+prenom+"',VIS_ADRESSE='"+adresse+"',VIS_CP='"+cp+"',VIS_VILLE='"+ville+"',LAB_CODE='"+labCode+"' where VIS_MATRICULE='"+mat+"';");
        qDebug()<<"update VISITEUR set VIS_NOM='"+nom+"',VIS_PRENOM='"+prenom+"',VIS_ADRESSE='"+adresse+"',VIS_CP='"+cp+"',VIS_VILLE='"+ville+"',LAB_CODE='"+labCode+"' where VIS_MATRICULE='"+mat+"';";
    }
    else
    {
    req.exec("update VISITEUR set VIS_NOM='"+nom+"',VIS_PRENOM='"+prenom+"',VIS_ADRESSE='"+adresse+"',VIS_CP='"+cp+"',VIS_VILLE='"+ville+"',SEC_CODE='"+secCode+"',LAB_CODE='"+labCode+"' where VIS_MATRICULE='"+mat+"';");
    qDebug()<<"update VISITEUR set VIS_NOM='"+nom+"',VIS_PRENOM='"+prenom+"',VIS_ADRESSE='"+adresse+"',VIS_CP='"+cp+"',VIS_VILLE='"+ville+"',SEC_CODE='"+secCode+"',LAB_CODE='"+labCode+"' where VIS_MATRICULE='"+mat+"';";
    req.first();
    }
    int index=ui->comboBox_Vis_Mat_Mod->currentIndex();
    this->chargeListVis();
    ui->comboBox_Vis_Mat_Mod->setCurrentIndex(index);
    statusBar()->showMessage("Modification effectuee");
}

void Principale::on_pushButton_Vis_Supr_clicked()
{
    QStringList resultCombo=ui->comboBox_Vis_Mat_Mod->currentText().split(" ");
    QString mat=resultCombo[0];
    QSqlQuery req;
    req.exec("delete from OFFRIR where VIS_MATRICULE='"+mat+"';");
    req.first();
    req.exec("delete from RAPPORT_VISITE where VIS_MATRICULE='"+mat+"';");
    req.first();
    req.exec("delete from REALISER where VIS_MATRICULE='"+mat+"';");
    req.first();
    req.exec("delete from TRAVAILLER where VIS_MATRICULE='"+mat+"';");
    req.first();
    req.exec("delete from VISITEUR where VIS_MATRICULE='"+mat+"';");
    req.first();
    int index=ui->comboBox_Vis_Mat_Mod->currentIndex();
    this->chargeListVis();
    ui->comboBox_Vis_Mat_Mod->setCurrentIndex(index);
    statusBar()->showMessage("Suppression effectuee");
}
