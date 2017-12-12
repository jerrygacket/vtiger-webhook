# vtiger-webhook
custom webhook for create leads, contacts and etc. from modx formit
Вебхук для создания обращений, контактов и т.д. из компонента MODX FormIt.

На сайте:
 - Файл modx/crm-hook разместить в плагинах на сайте.
 - В html-форме прописать инпут с нужным value (lead,contact, etc.): <input type="hidden" name="form" value="lead"/>
 - В html-форме должны присутсвовать поля, обязательные для создания сущности. Например фамилия для обращения.
 - Сделать вызов хука в Формите: &hooks=`FormItSaveForm,crm-hook`

На сервере с вебхуком:
 - Основной файл webhook.php: определяем ответственного, определяем, что создаем и вызываем нужный скрипт
 - addLead.php - создает обращение
 - vtiger-login.php - получает sessionId и userId для дальнейшей работы с vtiger
