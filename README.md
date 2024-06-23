
<div>
	<h1 align="center">Movie Quotes</h1>
</div>


Welcome to Movie Quotes!

This application allows you to manage a collection of your favorite movies and their memorable quotes.

You can register, log in, and explore the app. Additionally, you have the option to log in using your Google account through Laravel Socialite. The application also supports password resets and email verification to ensure secure access to your account. Once logged in, you will be redirected to the news feed page. Here, you can view all the quotes shared by other users, along with their details, images, and comments. You can see the number of likes and comments each quote has received. What's more, you can like, unlike, or comment on any quote, with real-time notifications informing users when their quotes receive interactions.

You can add information about movies, including details and images, and attach quotes to them. These will then be visible on the news feed for others to enjoy. Additionally, you can edit and delete both movies and quotes, giving you full control over your contributions. 

The application is bilingual, supporting both English and Georgian, so you can use it in the language you prefer.

Users can also edit their profile details, such as their image, username, and password. The user-friendly interface ensures a smooth experience as you personalize your profile and engage with the community.

We are confident that you will have a good time using Movie Quotes and make meaningful connections along the way. Dive in and start sharing your favorite movie moments with others!

#

### Table of Contents

- [Prerequisites](#prerequisites)
- [Tech Stack](#tech-stack)
- [Getting Started](#getting-started)
- [Development](#development)
- [Resources](#resources)

#

### Prerequisites

-  PHP@8.3.2 and up
-  Composer@2.7.1 and up
- MySQL@8.0 and up

#

### Tech Stack

- [Laravel@11.x](https://laravel.com/docs/11.x) - Back-end Framework.
 - [Laravel Pusher](https://laravel.com/docs/11.x/broadcasting#pusher-channels) - package for real-time notifications.
- [Spatie Translatable](https://github.com/spatie/laravel-translatable
) - package for translations.


#

### Getting Started

1\. At first, you need to clone Back-end Movie Quotes Application repository from github:

```sh
git clone git@github.com:RedberryInternship/movie-quotes-back-soso-beriashvili.git
```  

2\. Next step requires you to run _composer install_ in order to install all the dependencies:

  

```sh

composer install

```

  

5\. Now set your env file. Go to the root of your Back-end project and execute the following command.

  

```sh

cp .env.example .env

```

  

And now you should provide **.env** file all the necessary  variables.
#  

### Env variable cofigurations:

 ####  1) Database variables:

> DB_CONNECTION=mysql 

> DB_HOST=127.0.0.1 

> DB_PORT=3306  

> DB_DATABASE=**\***  

> DB_USERNAME=**\***  

> DB_PASSWORD=**\***

 ####  2) Gmail variables for receiving Emails:


> MAIL_MAILER=smtp

> MAIL_HOST=smtp.gmail.com

> MAIL_PORT=465

> MAIL_USERNAME=

> MAIL_PASSWORD=

> MAIL_ENCRYPTION=ssl

> MAIL_FROM_NAME=
  
 ####  3) Pusher variables for receiving real-time notifications:

> PUSHER_APP_ID=

> PUSHER_APP_KEY=

> PUSHER_APP_SECRET=

> PUSHER_HOST=

 >PUSHER_PORT=443

 >PUSHER_SCHEME=

  >PUSHER_APP_CLUSTER=

#### 4) Google OAuth variables:

> GOOGLE_CLIENT_ID=

> GOOGLE_CLIENT_SECRET=

> GOOGLE_REDIRECT=

After setting up **.env** file, execute this command in order to cache environment variables:

  

```sh

php artisan config:cache
php artisan optimize

```

  

6\. Having successfully done that, execute the following:

  

```sh

php artisan key:generate

```

  

Which generates auth key.

  

#

  

### Migration

  

After successfully following the previous steps, you now need to migrate the database:

  

```sh

php artisan migrate

```

  

### Development

  

In order to seed the database to test the application for the development purposes. you can run:

  

```sh

php artisan migrate --seed

```

  

And to run the development server:

  

```sh

php artisan serve

```

  

#

### And that is it for setting up the Back-end part of the Movie Quotes' application!
#

### Resources

- [Detailed description of the project](https://redberry.gitbook.io/assignment-v-movie-quotes-upgraded/platpormis-gverdebi/pilmebi/pilmebis-sia)
- [Figma design of the project](https://www.figma.com/file/5uMXCg3itJwpzh9cVIK3hA/Movie-Quotes-Bootcamp-assignment?node-id=0%3A1)
- [DrawSQL Schema of the project](https://drawsql.app/teams/team-soso/diagrams/movie-quotes)
