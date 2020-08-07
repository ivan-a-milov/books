# Способы загрузки книги

Примеры файлов, на которых осуществлялось тестирование, находятся в директории `tests/files/`

## Консольная команда
```
./bin/console books:add ../examples/example.fb2
```

## Веб страница
```
http://localhost:8000/upload
```

## POST HTTP запрос
```
curl -X POST --data-binary "@../examples/example.epub" http://localhost:8000/post
```

# Функционал сводной статистики

Тут пока что заглушка.

```
http://localhost:8000/summary
```
