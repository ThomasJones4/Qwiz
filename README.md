<!-- PROJECT SHIELDS -->
[![Contributors][contributors-shield]][contributors-url]
[![Forks][forks-shield]][forks-url]
[![Stargazers][stars-shield]][stars-url]
[![Issues][issues-shield]][issues-url]
[![MIT License][license-shield]][license-url]
[![LinkedIn][linkedin-shield]][linkedin-url]



<!-- PROJECT LOGO -->
<br />
<p align="center">
  <a href="https://github.com/ThomasJones4/lockdownquiz">
      <h1 align="center" style="decoration:none;">Qwiz</h1>
  </a>

  <h3 align="center">An Open Source Live Quiz Platform</h3>

  <p align="center">
    <a href="https://qwiz.co.uk/">View Live</a>
    ·
    <a href="https://github.com/ThomasJones4/lockdownquiz/issues">Report Bug</a>
    ·
    <a href="https://github.com/ThomasJones4/lockdownquiz/issues">Request Feature</a>
  </p>
</p>



<!-- TABLE OF CONTENTS -->
## Table of Contents

* [About the Project](#about-the-project)
  * [Built With](#built-with)
* [Getting Started](#getting-started)
  * [Prerequisites](#prerequisites)
  * [Installation](#installation)
* [Usage](#usage)
* [Roadmap](#roadmap)
* [Contributing](#contributing)
* [License](#license)
* [Contact](#contact)
* [Acknowledgements](#acknowledgements)



<!-- ABOUT THE PROJECT -->
## About The Project

Qwiz is a web app built on laravel that allows pub style quizzes. After the UK doing into lockdown on 23rd March 2020, the need for virtual pub style quizzes grew within my social circles, to the point where pen and paper no longer cut it. This is my attempt at keeping people connected.


### Built With
* [Laravel ❤️❤️](https://github.com/laravel/laravel)
* [Bootstrap](https://github.com/twbs/bootstrap)
* [JQuery](https://github.com/jquery/jquery)


# Want to host your own Qwiz server?
<!-- GETTING STARTED -->
## Getting Started

The simple steps below will get you up and running with your own quizzes in no time.

### Installation

1. Clone the repo
```sh
git clone https://github.com/ThomasJones4/lockdownquiz.git
```
2. Install NPM packages
```sh
npm install
```
3. Install Composer packages
```sh
composer install
```
4. Create a fresh `.env` file
```sh
cp .env.example .env
```
5. Generate an encryption key
```sh
php artisan key:generate
```
6. Add database credentials and update `.env` file
```php
DB_CONNECTION=mysql
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```
7. Migrate the database
```sh
php artisan migrate
```
8. Create an AWS S3 bucket and update `.env` file
```php
AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=
AWS_BUCKET=
AWS_URL=
```

<!-- USAGE EXAMPLES -->
## Usage

Once a quiz has been created a user can create their own quiz, either from their own question or by using the random question genarator.

Participants can join by following a quiz masters join link both `/join/{your quiz id}` and `/🎲/{your quiz id}`. Once logged in or registered, they can join by using the 8 digit code from the quiz master (keep this secret as it prevents unwanted guests).

Every quiz must end with a results screen to allow the quiz master to mark the answers, however the quiz master can add breaks at any point though out the quiz (15 questions in? 👀🍻) and mark the question so far.

<!-- ROADMAP -->
## Roadmap

See the [open issues](https://github.com/ThomasJones4/lockdownquiz/issues) for a list of proposed features (and known issues).



<!-- CONTRIBUTING -->
## Contributing

Contributions are what make the open source community such an amazing place to be learn, inspire, and create. Any contributions you make are **greatly appreciated**.

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request



<!-- LICENSE -->
## License

Distributed under the MIT License. See `LICENSE` for more information.



<!-- CONTACT -->
## Contact

Thomas Jones - [LinkedIn](https://linkedin.com/thomasjpjones) - thomasj2015@outlook.com

Project Link: [https://github.com/ThomasJones4/lockdownquiz](https://github.com/ThomasJones4/lockdownquiz)



<!-- ACKNOWLEDGEMENTS -->
## Acknowledgements
* [OpenTDB](https://opentdb.com/) by [PIXELTAIL GAME LLC](https://www.pixeltailgames.com/). Used under licence [CC BY 4.0](https://creativecommons.org/licenses/by-sa/4.0/)
* [Img Shields](https://shields.io)
* [Font Awesome](https://fontawesome.com)
* [Argon](https://github.com/creativetimofficial/argon-dashboard-laravel)
* [Laravel Dusk](https://github.com/laravel/dusk)


<!-- MARKDOWN LINKS & IMAGES -->
<!-- https://www.markdownguide.org/basic-syntax/#reference-style-links -->
[contributors-shield]: https://img.shields.io/github/contributors/ThomasJones4/lockdownquiz.svg?style=flat-square
[contributors-url]: https://github.com/ThomasJones4/lockdownquiz/graphs/contributors
[forks-shield]: https://img.shields.io/github/forks/ThomasJones4/lockdownquiz.svg?style=flat-square
[forks-url]: https://github.com/ThomasJones4/lockdownquiz/network/members
[stars-shield]: https://img.shields.io/github/stars/ThomasJones4/lockdownquiz.svg?style=flat-square
[stars-url]: https://github.com/ThomasJones4/lockdownquiz/stargazers
[issues-shield]: https://img.shields.io/github/issues/ThomasJones4/lockdownquiz.svg?style=flat-square
[issues-url]: https://github.com/ThomasJones4/lockdownquiz/issues
[license-shield]: https://img.shields.io/github/license/ThomasJones4/lockdownquiz.svg?style=flat-square
[license-url]: https://github.com/ThomasJones4/lockdownquiz/blob/master/LICENSE.txt
[linkedin-shield]: https://img.shields.io/badge/-LinkedIn-black.svg?style=flat-square&logo=linkedin&colorB=555
[linkedin-url]: https://linkedin.com/in/thomasjpjones
