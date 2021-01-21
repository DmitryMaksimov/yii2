Развертывание проекта на примере OpenServer

1. Зайти в директорию проектов OpenServer

2. Открыть окно команд и выполнить:

    <code>
	git clone https://github.com/DmitryMaksimov/yii2
    </code>
	
    Появится папка yii2

3. Скофигурировать OpenServer

    <img src="openserver.png"/>

    <img src="openserver2.png"/>

4. Проинициализировать Yii командой

    <code>composer update</code>

5. Инициализировать проект

    <code>yii init</code>

    Выбрав продакшн или девелопмент режим (со всем соглашаться)

6. Настроить параметры базы данных в файле /common/config/main-local.php

    <comment>Для OpenServer надо поставить пароль root и прописать имя предварительно созданной БД и не забыть сохранить</comment>

7. Выполнить миграцию

    <code>yii migrate</code>

8. Выполнить миграцию Rbac

    <code>yii migrate --migrationPath=@yii/rbac/migrations/</code>

9. Зайти на сайт <a href='yii2/index.php?r=site%2Fsignup'>yii2/</a> и создать пользователя (пользователь с id = 1 будет администратором)

10. Проверить почту в папке /frontend/rutime/mail/

    <warning>Открыть письмо в браузере и пройти по ссылке</warning>

11. Выполнить инициализацию Rbac

    <code>yii rbac/init</code>