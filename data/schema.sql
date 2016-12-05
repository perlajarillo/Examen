CREATE TABLE examen (id INTEGER PRIMARY KEY AUTOINCREMENT, materia VARCHAR(30) NOT NULL, unidad INT NOT NULL);
CREATE TABLE pregunta (id_pregunta INTEGER PRIMARY KEY AUTOINCREMENT, texto VARCHAR(100) NOT NULL, id_respuesta INT, id_examen INT);
CREATE TABLE respuesta (id_respuesta INTEGER PRIMARY KEY AUTOINCREMENT, texto VARCHAR(30) NOT NULL, id_pregunta INT, correcta BOOLEAN);