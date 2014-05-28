# -------------------------------------------------
# Project created by QtCreator 2013-10-03T14:25:47
# -------------------------------------------------
QT       += core gui\
            sql
greaterThan(QT_MAJOR_VERSION, 4): QT += widgets

TARGET = BackOfficeCR
TEMPLATE = app
SOURCES += main.cpp \
    principale.cpp \
    dialogconnection.cpp
HEADERS += principale.h \
    dialogconnection.h
FORMS += principale.ui \
    dialogconnection.ui

RESOURCES += \
    image.qrc
