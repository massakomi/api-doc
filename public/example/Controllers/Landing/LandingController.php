<?php
namespace Controllers\Landing;

class LandingController
{

    /**
     * Навигация для лендинга
     *
     * @group Лендинг
     *
     * @responseField id int Ид элемента
     * @responseField slideText string|false Текст для слайда
     * @responseField sort int Сортировка
     *
     * @return array
     */
    public function menuAction(): array
    {

    }

    /**
     * Как принять участие
     *
     * @group Лендинг
     *
     * @responseField id int Ид элемента
     * @responseField title string Заголовок элемента
     * @responseField subTitle string|false Подзаголовок элемента
     * @responseField showButtonUploadReceipt boolean Выводить ли кнопку "Загрузить чек"
     * @responseField slideTitle string|false Заголовок для слайда
     * @responseField slideText string|false Текст для слайда
     * @responseField image string|null Картинка в слайде
     * @responseField sort int Сортировка
     *
     * @return array
     */
    public function howToEnterAction(): array
    {

    }

    /**
     * Призы
     *
     * После успешной авторизации на фронте нужно выполнить урл /local/components/aim/auth.reg.form/cross.php?json - это нужно чтобы работала сквозная авторизация (авторизовавшись на лендинге, юзер сразу будет авторизован и на зеленой волне). Проблема в косяке битрикса, он не может сделать сквозную авторизацию без такого http запроса.
     *
     * @group Лендинг
     *
     * @responseField elements array Массив элементов ссылок
     * @responseField elements.title string Заголовок элемента
     * @responseField elements.icon string Иконка
     * @responseField elements.url string Url
     *
     * @param string phone Телефон (можно с пробелами)
     * @param string url URL с которого идет вход
     *
     * @return array
     */
    public function prizesAction(): array
    {

    }

}
