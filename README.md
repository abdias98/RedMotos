# Entrevista Técnica - Red Motos

<img src="https://motos.redmotoshn.com/img/logo.png" width="200px" />

¡Bienvenido! Has llegado a la etapa final del proceso de selección, donde pondremos a prueba tus conocimientos técnicos. En esta fase, te enfrentarás a un ejercicio que consiste en la ejecución de un proyecto de complejidad baja-media. Aquí tendrás la oportunidad de demostrar tus habilidades como desarrollador web.

Te animo a que leas detenidamente las instrucciones y sigas las indicaciones al pie de la letra. Si tienes alguna pregunta o duda, no dudes en contactarme a través del correo electrónico. ¡Estoy aquí para ayudarte! Te deseo mucho éxito en esta etapa final del proceso de selección.

## 🚀 Sistema de Gestión de Tareas y Proyectos

### Descripción
El objetivo de este proyecto es desarrollar una aplicación web que permita a los equipos de trabajo **organizar, asignar y dar seguimiento** a las **tareas y proyectos** de manera eficiente. La aplicación proporcionará un entorno colaborativo donde los miembros del equipo puedan coordinar sus actividades, compartir archivos y comunicarse de manera efectiva.

### I - Características principales:

✔️ Registro de tareas: Los usuarios podrán crear y registrar tareas con información detallada, como descripción, prioridad, fechas límite y asignación de responsables.

📝 Asignación y seguimiento: Los miembros del equipo podrán asignar tareas a sí mismos o a otros miembros del equipo (Una tarea solo puede tener un responsable, es decir solo puedo asignar una tarea a una usuario), lo que permitirá una clara asignación de responsabilidades. Además, podrán realizar un seguimiento del progreso de las tareas y marcarlas como completadas una vez finalizadas.

📂 Organización de proyectos: Los usuarios podrán crear proyectos y agrupar tareas relacionadas en cada proyecto. Esto facilitará la gestión de múltiples proyectos y permitirá una visión general de los avances y el estado de cada proyecto.

💬 Comunicación y colaboración: La aplicación proporcionará funciones de comunicación y colaboración, como comentarios en las tareas y compartición de archivos (extra). Esto permitirá a los miembros del equipo interactuar y colaborar de manera efectiva.

🗓️ Calendario y recordatorios: La aplicación incluirá un calendario donde se mostrarán las tareas. Se deberá mostrar las tareas que han sido asignadas en cada fecha.

📊 Informes y métricas: Se proporcionarán informes y métricas simples para evaluar el progreso del proyecto, el desempeño individual y la carga de trabajo. Esto permitirá a los equipos realizar un seguimiento del rendimiento y realizar ajustes si es necesario.

## II - Requerimientos iniciales
Una vez que tengas claro lo que se solicita, completa el siguiente formulario: [Entrevista Técnica - Desarrollador Web Red Motos](https://forms.gle/DbYUebkQ6vUzmUfXA)

## III - Entregable
* El proyecto debe ser funcional.
* Tienes total libertad para llevar a cabo el proyecto, lo que implica que puedes tomar cualquier decisión que consideres conveniente para su implementación.
* Es necesario utilizar Git como herramienta de control de versiones para gestionar el proyecto de manera efectiva.
* Debes realizar un fork de este proyecto o descargarlo y subirlo a un repositorio personal público.
* Asegúrate de incluir los pasos necesarios para iniciar el proyecto en la sección indicada al final de este archivo.
Es importante cumplir con las fechas definidas (llenar el formulario de requerimientos iniciales).

## IV - Extra
Lo siguiente no forma parte de la evaluación principal pero sumará puntos extra al resultado final.
* Utilizar Vue para desarrollar el frontEnd
* Incluir pruebas automatizadas.
* Video a modo de demo presentando el proyecto.

## V - Elementos a Evaluar
Calidad del código, legibilidad, reusabilidad, atención al detalle en el diseño de interfaces y la implementación de buenas prácticas de desarrollo.


## VI - Pasos para iniciar/ejecutar el proyecto [Completa esta sección]# RedMotos
* Ejecutar comando composer update
* Ejecutar comando npm install (Si no se tiene instalado node.js, aqui esta el URL para descargar y luego instalarlo https://nodejs.org/en)
* Ejecutar comando npm run dev
* Crear base de datos y configurarla en el archivo .env con las credenciales de la que se quiera usar
* Migrar la base de datos y ejecutar los seeders con el comando php artisan migrate --seed
* Ejecutar comando php artisan storage:link y dentro de la carpeta storage/app/public guardar el archivo doc.png que está en la raíz del proyecto
