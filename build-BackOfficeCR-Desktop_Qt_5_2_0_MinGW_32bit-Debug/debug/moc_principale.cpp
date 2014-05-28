/****************************************************************************
** Meta object code from reading C++ file 'principale.h'
**
** Created by: The Qt Meta Object Compiler version 67 (Qt 5.2.0)
**
** WARNING! All changes made in this file will be lost!
*****************************************************************************/

#include "../../BackOfficeCR/principale.h"
#include <QtCore/qbytearray.h>
#include <QtCore/qmetatype.h>
#if !defined(Q_MOC_OUTPUT_REVISION)
#error "The header file 'principale.h' doesn't include <QObject>."
#elif Q_MOC_OUTPUT_REVISION != 67
#error "This file was generated using the moc from 5.2.0. It"
#error "cannot be used with the include files from this version of Qt."
#error "(The moc has changed too much.)"
#endif

QT_BEGIN_MOC_NAMESPACE
struct qt_meta_stringdata_Principale_t {
    QByteArrayData data[15];
    char stringdata[486];
};
#define QT_MOC_LITERAL(idx, ofs, len) \
    Q_STATIC_BYTE_ARRAY_DATA_HEADER_INITIALIZER_WITH_OFFSET(len, \
    offsetof(qt_meta_stringdata_Principale_t, stringdata) + ofs \
        - idx * sizeof(QByteArrayData) \
    )
static const qt_meta_stringdata_Principale_t qt_meta_stringdata_Principale = {
    {
QT_MOC_LITERAL(0, 0, 10),
QT_MOC_LITERAL(1, 11, 44),
QT_MOC_LITERAL(2, 56, 0),
QT_MOC_LITERAL(3, 57, 32),
QT_MOC_LITERAL(4, 90, 32),
QT_MOC_LITERAL(5, 123, 30),
QT_MOC_LITERAL(6, 154, 47),
QT_MOC_LITERAL(7, 202, 50),
QT_MOC_LITERAL(8, 253, 31),
QT_MOC_LITERAL(9, 285, 29),
QT_MOC_LITERAL(10, 315, 30),
QT_MOC_LITERAL(11, 346, 33),
QT_MOC_LITERAL(12, 380, 43),
QT_MOC_LITERAL(13, 424, 29),
QT_MOC_LITERAL(14, 454, 30)
    },
    "Principale\0on_comboBox_Prat_Num_Mod_currentIndexChanged\0"
    "\0on_pushButton_Prat_Ajout_clicked\0"
    "on_pushButton_Prat_Suppr_clicked\0"
    "on_pushButton_Prat_Mod_clicked\0"
    "on_comboBox_Med_Famille_Mod_currentIndexChanged\0"
    "on_comboBox_Med_DepotLegal_Mod_currentIndexChanged\0"
    "on_pushButton_Med_Ajout_clicked\0"
    "on_pushButton_Med_Mod_clicked\0"
    "on_pushButton_Med_Supr_clicked\0"
    "on_pushButton_Vis_Ajouter_clicked\0"
    "on_comboBox_Vis_Mat_Mod_currentIndexChanged\0"
    "on_pushButton_Vis_Mod_clicked\0"
    "on_pushButton_Vis_Supr_clicked\0"
};
#undef QT_MOC_LITERAL

static const uint qt_meta_data_Principale[] = {

 // content:
       7,       // revision
       0,       // classname
       0,    0, // classinfo
      13,   14, // methods
       0,    0, // properties
       0,    0, // enums/sets
       0,    0, // constructors
       0,       // flags
       0,       // signalCount

 // slots: name, argc, parameters, tag, flags
       1,    0,   79,    2, 0x08,
       3,    0,   80,    2, 0x08,
       4,    0,   81,    2, 0x08,
       5,    0,   82,    2, 0x08,
       6,    0,   83,    2, 0x08,
       7,    0,   84,    2, 0x08,
       8,    0,   85,    2, 0x08,
       9,    0,   86,    2, 0x08,
      10,    0,   87,    2, 0x08,
      11,    0,   88,    2, 0x08,
      12,    0,   89,    2, 0x08,
      13,    0,   90,    2, 0x08,
      14,    0,   91,    2, 0x08,

 // slots: parameters
    QMetaType::Void,
    QMetaType::Void,
    QMetaType::Void,
    QMetaType::Void,
    QMetaType::Void,
    QMetaType::Void,
    QMetaType::Void,
    QMetaType::Void,
    QMetaType::Void,
    QMetaType::Void,
    QMetaType::Void,
    QMetaType::Void,
    QMetaType::Void,

       0        // eod
};

void Principale::qt_static_metacall(QObject *_o, QMetaObject::Call _c, int _id, void **_a)
{
    if (_c == QMetaObject::InvokeMetaMethod) {
        Principale *_t = static_cast<Principale *>(_o);
        switch (_id) {
        case 0: _t->on_comboBox_Prat_Num_Mod_currentIndexChanged(); break;
        case 1: _t->on_pushButton_Prat_Ajout_clicked(); break;
        case 2: _t->on_pushButton_Prat_Suppr_clicked(); break;
        case 3: _t->on_pushButton_Prat_Mod_clicked(); break;
        case 4: _t->on_comboBox_Med_Famille_Mod_currentIndexChanged(); break;
        case 5: _t->on_comboBox_Med_DepotLegal_Mod_currentIndexChanged(); break;
        case 6: _t->on_pushButton_Med_Ajout_clicked(); break;
        case 7: _t->on_pushButton_Med_Mod_clicked(); break;
        case 8: _t->on_pushButton_Med_Supr_clicked(); break;
        case 9: _t->on_pushButton_Vis_Ajouter_clicked(); break;
        case 10: _t->on_comboBox_Vis_Mat_Mod_currentIndexChanged(); break;
        case 11: _t->on_pushButton_Vis_Mod_clicked(); break;
        case 12: _t->on_pushButton_Vis_Supr_clicked(); break;
        default: ;
        }
    }
    Q_UNUSED(_a);
}

const QMetaObject Principale::staticMetaObject = {
    { &QMainWindow::staticMetaObject, qt_meta_stringdata_Principale.data,
      qt_meta_data_Principale,  qt_static_metacall, 0, 0}
};


const QMetaObject *Principale::metaObject() const
{
    return QObject::d_ptr->metaObject ? QObject::d_ptr->dynamicMetaObject() : &staticMetaObject;
}

void *Principale::qt_metacast(const char *_clname)
{
    if (!_clname) return 0;
    if (!strcmp(_clname, qt_meta_stringdata_Principale.stringdata))
        return static_cast<void*>(const_cast< Principale*>(this));
    return QMainWindow::qt_metacast(_clname);
}

int Principale::qt_metacall(QMetaObject::Call _c, int _id, void **_a)
{
    _id = QMainWindow::qt_metacall(_c, _id, _a);
    if (_id < 0)
        return _id;
    if (_c == QMetaObject::InvokeMetaMethod) {
        if (_id < 13)
            qt_static_metacall(this, _c, _id, _a);
        _id -= 13;
    } else if (_c == QMetaObject::RegisterMethodArgumentMetaType) {
        if (_id < 13)
            *reinterpret_cast<int*>(_a[0]) = -1;
        _id -= 13;
    }
    return _id;
}
QT_END_MOC_NAMESPACE
