/********************************************************************************
** Form generated from reading UI file 'dialogconnection.ui'
**
** Created: Thu Dec 19 16:11:44 2013
**      by: Qt User Interface Compiler version 4.8.2
**
** WARNING! All changes made in this file will be lost when recompiling UI file!
********************************************************************************/

#ifndef UI_DIALOGCONNECTION_H
#define UI_DIALOGCONNECTION_H

#include <QtCore/QVariant>
#include <QAction>
#include <QApplication>
#include <QButtonGroup>
#include <QDialog>
#include <QDialogButtonBox>
#include <QFrame>
#include <QGridLayout>
#include <QHBoxLayout>
#include <QHeaderView>
#include <QLabel>
#include <QLineEdit>
#include <QSpacerItem>
#include <QStackedWidget>
#include <QVBoxLayout>
#include <QWidget>

QT_BEGIN_NAMESPACE

class Ui_DialogConnection
{
public:
    QGridLayout *gridLayout;
    QStackedWidget *stackedWidget;
    QWidget *page;
    QGridLayout *gridLayout_2;
    QSpacerItem *verticalSpacer_2;
    QSpacerItem *horizontalSpacer_4;
    QVBoxLayout *verticalLayout_2;
    QLabel *label_3;
    QFrame *line;
    QHBoxLayout *horizontalLayout_3;
    QSpacerItem *horizontalSpacer_2;
    QVBoxLayout *verticalLayout;
    QHBoxLayout *horizontalLayout;
    QLabel *label;
    QLineEdit *lineEdit_Matricule;
    QHBoxLayout *horizontalLayout_2;
    QLabel *label_2;
    QLineEdit *lineEdit_Password;
    QDialogButtonBox *buttonBox_Connect;
    QSpacerItem *horizontalSpacer;
    QSpacerItem *horizontalSpacer_3;
    QSpacerItem *verticalSpacer;

    void setupUi(QDialog *DialogConnection)
    {
        if (DialogConnection->objectName().isEmpty())
            DialogConnection->setObjectName(QString::fromUtf8("DialogConnection"));
        DialogConnection->resize(461, 294);
        QIcon icon;
        icon.addFile(QString::fromUtf8(":/Image/logo"), QSize(), QIcon::Normal, QIcon::Off);
        DialogConnection->setWindowIcon(icon);
        DialogConnection->setAutoFillBackground(true);
        DialogConnection->setStyleSheet(QString::fromUtf8("\n"
"QStackedWidget{ border-image: url(:/Image/logo)}"));
        gridLayout = new QGridLayout(DialogConnection);
        gridLayout->setObjectName(QString::fromUtf8("gridLayout"));
        stackedWidget = new QStackedWidget(DialogConnection);
        stackedWidget->setObjectName(QString::fromUtf8("stackedWidget"));
        page = new QWidget();
        page->setObjectName(QString::fromUtf8("page"));
        gridLayout_2 = new QGridLayout(page);
        gridLayout_2->setObjectName(QString::fromUtf8("gridLayout_2"));
        verticalSpacer_2 = new QSpacerItem(20, 41, QSizePolicy::Minimum, QSizePolicy::Expanding);

        gridLayout_2->addItem(verticalSpacer_2, 0, 1, 1, 1);

        horizontalSpacer_4 = new QSpacerItem(38, 20, QSizePolicy::Expanding, QSizePolicy::Minimum);

        gridLayout_2->addItem(horizontalSpacer_4, 1, 0, 1, 1);

        verticalLayout_2 = new QVBoxLayout();
        verticalLayout_2->setObjectName(QString::fromUtf8("verticalLayout_2"));
        label_3 = new QLabel(page);
        label_3->setObjectName(QString::fromUtf8("label_3"));
        QFont font;
        font.setFamily(QString::fromUtf8("DejaVu Serif"));
        font.setPointSize(14);
        font.setBold(true);
        font.setItalic(true);
        font.setWeight(75);
        label_3->setFont(font);

        verticalLayout_2->addWidget(label_3);

        line = new QFrame(page);
        line->setObjectName(QString::fromUtf8("line"));
        line->setFrameShape(QFrame::HLine);
        line->setFrameShadow(QFrame::Sunken);

        verticalLayout_2->addWidget(line);

        horizontalLayout_3 = new QHBoxLayout();
        horizontalLayout_3->setObjectName(QString::fromUtf8("horizontalLayout_3"));
        horizontalSpacer_2 = new QSpacerItem(40, 20, QSizePolicy::Expanding, QSizePolicy::Minimum);

        horizontalLayout_3->addItem(horizontalSpacer_2);

        verticalLayout = new QVBoxLayout();
        verticalLayout->setObjectName(QString::fromUtf8("verticalLayout"));
        horizontalLayout = new QHBoxLayout();
        horizontalLayout->setObjectName(QString::fromUtf8("horizontalLayout"));
        label = new QLabel(page);
        label->setObjectName(QString::fromUtf8("label"));
        QFont font1;
        font1.setPointSize(12);
        font1.setBold(false);
        font1.setItalic(true);
        font1.setWeight(50);
        label->setFont(font1);

        horizontalLayout->addWidget(label);

        lineEdit_Matricule = new QLineEdit(page);
        lineEdit_Matricule->setObjectName(QString::fromUtf8("lineEdit_Matricule"));
        lineEdit_Matricule->setAutoFillBackground(false);

        horizontalLayout->addWidget(lineEdit_Matricule);


        verticalLayout->addLayout(horizontalLayout);

        horizontalLayout_2 = new QHBoxLayout();
        horizontalLayout_2->setObjectName(QString::fromUtf8("horizontalLayout_2"));
        label_2 = new QLabel(page);
        label_2->setObjectName(QString::fromUtf8("label_2"));
        label_2->setFont(font1);

        horizontalLayout_2->addWidget(label_2);

        lineEdit_Password = new QLineEdit(page);
        lineEdit_Password->setObjectName(QString::fromUtf8("lineEdit_Password"));
        lineEdit_Password->setEchoMode(QLineEdit::Password);

        horizontalLayout_2->addWidget(lineEdit_Password);


        verticalLayout->addLayout(horizontalLayout_2);

        buttonBox_Connect = new QDialogButtonBox(page);
        buttonBox_Connect->setObjectName(QString::fromUtf8("buttonBox_Connect"));
        buttonBox_Connect->setOrientation(Qt::Horizontal);
        buttonBox_Connect->setStandardButtons(QDialogButtonBox::Cancel|QDialogButtonBox::Ok);

        verticalLayout->addWidget(buttonBox_Connect);


        horizontalLayout_3->addLayout(verticalLayout);

        horizontalSpacer = new QSpacerItem(40, 20, QSizePolicy::Expanding, QSizePolicy::Minimum);

        horizontalLayout_3->addItem(horizontalSpacer);


        verticalLayout_2->addLayout(horizontalLayout_3);


        gridLayout_2->addLayout(verticalLayout_2, 1, 1, 1, 1);

        horizontalSpacer_3 = new QSpacerItem(46, 20, QSizePolicy::Expanding, QSizePolicy::Minimum);

        gridLayout_2->addItem(horizontalSpacer_3, 1, 2, 1, 1);

        verticalSpacer = new QSpacerItem(20, 47, QSizePolicy::Minimum, QSizePolicy::Expanding);

        gridLayout_2->addItem(verticalSpacer, 2, 1, 1, 1);

        stackedWidget->addWidget(page);

        gridLayout->addWidget(stackedWidget, 0, 1, 1, 1);


        retranslateUi(DialogConnection);
        QObject::connect(buttonBox_Connect, SIGNAL(accepted()), DialogConnection, SLOT(accept()));
        QObject::connect(buttonBox_Connect, SIGNAL(rejected()), DialogConnection, SLOT(reject()));

        stackedWidget->setCurrentIndex(0);


        QMetaObject::connectSlotsByName(DialogConnection);
    } // setupUi

    void retranslateUi(QDialog *DialogConnection)
    {
        DialogConnection->setWindowTitle(QApplication::translate("DialogConnection", "Connexion", 0));
        label_3->setText(QApplication::translate("DialogConnection", "D\303\251clinez votre identit\303\251:", 0));
        label->setText(QApplication::translate("DialogConnection", "Matricule  :", 0));
        label_2->setText(QApplication::translate("DialogConnection", "Password :", 0));
    } // retranslateUi

};

namespace Ui {
    class DialogConnection: public Ui_DialogConnection {};
} // namespace Ui

QT_END_NAMESPACE

#endif // UI_DIALOGCONNECTION_H
