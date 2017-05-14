API VK для создания бота
==================

Описание
------------------

Планируется доделать все это до полноценной библиотеки управления ботов в социальной сети vk.com

Сейчас набор содержить только начальные, базовые методы, для начала тестов.

Начну с того, что для работы требуется config.php, которого нет в репозитории.
 В нем содержится секретный токен для доступа к приложению вк и доступу к странице.
 По сути это просто переменная, которую вы можете сами написать, и задать значение.
 
 $token = 'ВАШ ТОКЕН и ВК'; Как его получить, подробно написано в документации по API VK.
 Далее вам нужно будет передать эту переменную при вызове экземляра класса (в конструктор)
 
Методы класса ApiMethods
--------------------------

**getProfileInfo()** - дописывает запрос к апи для получения данных профиля

**AccountSetOnline()** - отправляет онлайн идентификатор, чтобы показывать что в сети. На 5 минут

**SendMessageUser($userid, $message)** - отправляет сообщение пользователю

**getMessage($time_offset = 60)** - получает сообщения за последние 60 (по умолчанию) секунд

**getUsers($users_id)** - получает одного или нескольких пользователей по id. Можно передать строку и перечислить через запятую

**APIExecute($response = true)** - выполняет собранный запрос. Все методы выше, только собирают его,
а данный метод его именно выполняет и возвращает ответ. Если в положении ИСТИНА, то в том виде, как отдает сервер ВК, иначе,
пробует сделать json_decode($array, true)  и вернуть ассоциативный массив

**getError()** - получает сообщение об ошибке, если она возникла

**getAPI()** - получает строку API до присоединения токена и версии и выполняется до APIExecute()

**ClearAPI()** - очищает собранный или выполненный запрос, и можно не создавая нового экземпляра класса посылать новые запросы.


Примеры
---------

Все примеры, пока тестите сами, или смотрите в index.php

По мере доработок буду стараться описывать конкретные случаи



