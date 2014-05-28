/****************************************************************************
** Meta object code from reading C++ file 'dialogconnection.h'
**
** Created by: The Qt Meta Object Compiler version 67 (Qt 5.2.0)
**
** WARNING! All changes made in this file will be lost!
*****************************************************************************/

#include "../../BackOfficeCR/dialogconnection.h"
#include <QtCore/qbytearray.h>
#include <QtCore/qmetatype.h>
#if !defined(Q_MOC_OUTPUT_REVISION)
#error "The header file 'dialogconnection.h' doesn't include <QObject>."
#elif Q_MOC_OUTPUT_REVISION != 67
#error "This file was generated using the moc from 5.2.0. It"
#error "cannot be used with the include files from this version of Qt."
#error "(The moc has changed too much.)"
#endif

QT_BEGIN_MOC_NAMESPACE
struct qt_meta_stringdata_DialogConnection_t {
    QByteArrayData data[4];
    char stringdata[79];
};
#define QT_MOC_LITERAL(idx, ofs, len) \
    Q_STATIC_BYTE_ARRAY_DATA_HEADER_INITIALIZER_WITH_OFFSET(len, \
    offsetof(qt_meta_stringdata_DialogConnection_t, stringdata) + ofs \
        - idx * sizeof(QByteArrayData) \
    )
static const qt_meta_stringdata_DialogConnection_t qt_meta_stringdata_DialogConnection = {
    {
QT_MOC_LITERAL(0, 0, 16),
QT_MOC_LITERAL(1, 17, 29),
QT_MOC_LITERAL(2, 47, 0),
QT_MOC_LITERAL(3, 48, 29)
    },
    "DialogConnection\0on_buttonBox_Connect_rejected\0"
    "\0on_buttonBox_Connect_accepted\0"
};
#undef QT_MOC_LITERAL

static const uint qt_meta_data_DialogConnection[] = {

 // content:
       7,       // revision
       0,       // classname
       0,    0, // classinfo
       2,   14, // methods
       0,    0, // properties
       0,    0, // enums/sets
       0,    0, // constructors
       0,       // flags
       0,       // signalCount

 // slots: name, argc, parameters, tag, flags
       1,    0,   24,    2, 0x08,
       3,    0,   25,    2, 0x08,

 // slots: parameters
    QMetaType::Void,
    QMetaType::Void,

       0        // eod
};

void DialogConnection::qt_static_metacall(QObject *_o, QMetaObject::Call _c, int _id, void **_a)
{
    if (_c == QMetaObject::InvokeMetaMethod) {
        DialogConnection *_t = static_cast<DialogConnection *>(_o);
        switch (_id) {
        case 0: _t->on_buttonBox_Connect_rejected(); break;
        case 1: _t->on_buttonBox_Connect_accepted(); break;
        default: ;
        }
    }
    Q_UNUSED(_a);
}

const QMetaObject DialogConnection::staticMetaObject = {
    { &QDialog::staticMetaObject, qt_meta_stringdata_DialogConnection.data,
      qt_meta_data_DialogConnection,  qt_static_metacall, 0, 0}
};


const QMetaObject *DialogConnection::metaObject() const
{
    return QObject::d_ptr->metaObject ? QObject::d_ptr->dynamicMetaObject() : &staticMetaObject;
}

void *DialogConnection::qt_metacast(const char *_clname)
{
    if (!_clname) return 0;
    if (!strcmp(_clname, qt_meta_stringdata_DialogConnection.stringdata))
        return static_cast<void*>(const_cast< DialogConnection*>(this));
    return QDialog::qt_metacast(_clname);
}

int DialogConnection::qt_metacall(QMetaObject::Call _c, int _id, void **_a)
{
    _id = QDialog::qt_metacall(_c, _id, _a);
    if (_id < 0)
        return _id;
    if (_c == QMetaObject::InvokeMetaMethod) {
        if (_id < 2)
            qt_static_metacall(this, _c, _id, _a);
        _id -= 2;
    } else if (_c == QMetaObject::RegisterMethodArgumentMetaType) {
        if (_id < 2)
            *reinterpret_cast<int*>(_a[0]) = -1;
        _id -= 2;
    }
    return _id;
}
QT_END_MOC_NAMESPACE
