BX.ajax.runComponentAction("machaon:feedback", "send", {
    mode: "class",
    data: {
        "email": "vasya@email.tld",
        "username": "Василий",
        "message": "Где мой заказ? Жду уже целый час!"
    }
}).then(function (response) {
    // обработка ответа
});