Introduction
============

## Goal

The goal of this assignment is for you – the candidate – to display your technical knowledge and experience by developing a fictitious web application within our product's tech stack. This will provide you a realistic sense of your responsibilities as a full stack engineer and our expectations of the role.

You'll be developing a professional network application named "LinkedUp," where a single user can manage a simple contact list and connections between people they know.

The assignment is divided into two chapters. The first chapter focuses on developing the necessary MVC components while additionally testing your knowledge of view templating.

The second chapter focuses on developing a more complex client using React/Redux, testing your knowledge of state management within a single page application and communication to the server via a REST API.

Throughout the assignment you'll be provided some guidance and direction, though many details are left out in part for the exercise.

## Installation

You'll need Docker on your machine in order to configure and run the required services. Install [Docker for Mac](https://docs.docker.com/docker-for-mac/install/) if you have not done so already. Run `docker -v` to verify you have version `17.09.0` or greater installed. We recommend staying up-to-date on the stable channel.

Clone https://bitbucket.org/engrain/xp-interview-assignment to your machine. Once cloned, within the working directory run `docker-compose up -d`.

> The process may take several minutes as Docker downloads, builds, and runs the services declared in `docker-compose.yml`.

Next run `docker-compose exec app composer install` to install dependant composer packages.

Once finished, open `http://localhost` in your Browser and you should see the Engrain logo. This indicates the installation was successful.

Create a new branch named `my-work`. This branch will be used to commit your progress on each chapter.

```
$ git checkout -b my-work
```

Move onto `02-chapter-1.md`.
