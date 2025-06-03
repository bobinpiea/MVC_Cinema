I- DESIGN PATTERN

« Modele de référence qui sert de source d’inspiration lors de la conception  d’une chose »

1995 : Lire Design Patterns - Gang of Four ou GOF —>  ce qui donna un nom et un mode d’emploi à près de 25 patrons

Il existe beaucoup de pattern qui vont influencer tant le code que l’organisation et l’interdépendance des fichiers/dossiers .


II - Exemples

	•	Factory : c’est comme une “usine” qui crée le bon objet quand on lui dit ce qu’on veut, sans qu’on ait à savoir comment elle le fabrique.

	•	Composite : ça permet de traiter un seul objet ou un groupe d’objets exactement de la même façon, comme si c’était toujours un seul élément.

	•	Iterator : c’est un guide qui permet de parcourir un ensemble d’objets un à un (comme tourner les pages d’un livre) sans se soucier de comment ils sont rangés.

	•	Observer : c’est un système où un objet principal prévient plusieurs “amis” quand quelque chose change, et chacun réagit comme il veut.

	•	Singleton : c’est une règle qui garantit qu’il n’y aura toujours qu’un seul exemplaire d’un objet, un peu comme une télécommande unique pour la télé.

	•	Strategy : ça organise plusieurs façons de faire un calcul ou une tâche, pour pouvoir choisir facilement laquelle utiliser sans changer tout le programme.

	•	Template : c’est un plan général d’algorithme où certaines étapes sont laissées vides, et les “enfants” du plan peuvent remplir ou modifier juste ces étapes tout en gardant la même structure globale.

III. Les patterns MVC et MVP

	•	MVC (Modèle-Vue-Contrôleur) : sépare une application en trois parties (données, affichage, gestion des actions) pour organiser clairement où se trouvent les informations, ce qu’on voit à l’écran et comment réagir aux clics.

	•	MVP (Modèle-Vue-Présentateur) : ressemble à MVC, mais la vue ne parle qu’au présentateur (qui lui-même gère le modèle), pour que l’affichage soit entièrement piloté par une couche qui fait le lien avec les données.

IV. Front-Controller

	•	Front-Controller : dans une application web, c’est le fichier unique qui sert de « porte d’entrée » et redirige chaque requête vers le bon contrôleur, centralisant ainsi la gestion des routes, de la sécurité et de la configuration.



	MVC_CINEMA


	• Namespace : Un namespace est comme un classeur ou un dossier qui contient les classes “du même domaine” - De la meme utilité. ? ex: classeur travail, cuisine, 