Test task
=========

### Демонстрация:

`docker run --rm -it agregad/chat-stats`

### Итераторы

В реализации используется два варианта алгоритма для прохода по структуре данных сообщений.
1) простая на основе рекурсии анонимной функции. Ограничение данного решения в том что глубина погружения ограничена настройками пхп стека вызова функций и при очень большой вложенности php выдаст ошибку
2) на основе встроенного в пхп RecursiveArrayIterator и RecursiveIteratorIterator итератора. С теоретической точки зрения они не должны быть завязаны на стек вызова функций и не должны иметь ограничений на глубину.

### Расчет значений 

Для сбора и вычисления информации используются отдельные классы анализаторы - MessageMaxLengthAnalyzer и MessagesAnswerAverageAnalyzer каждый из которые занимается расчетом своей характеристики.
Мы можем добавлять или убирать нужные нам параметры расчета добавляя или удаляя эти классы в начале работы. Это как пример принципа open–closed principle из SOLID

### Валидация 

Также в системе предусмотрена валидация при прохождении структуры сообщений.
Сделано два варианта реализации
1) Строгий валидатор - если сообщение не валидно - будет выброшен эксепшен и вся работа прекратится
2) Нестрогий валидатор - если сообщение не валидно - сообщение будет пропущено

### Тестирование

Код библиотеки разработан при помощи подхода TDD. Есть также один интеграционный тест использующий входнные данные из задания
