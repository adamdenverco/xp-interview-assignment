Chapter Two
===========

In this chapter, you will be implementing our LinkedUp app as a single page application with React/Redux.

> You can find resource files for this chapter under `guides/chapter-2`.

---

Before working on the client, we will implement the REST API the client will
rely on. Review the `api-spec.md` which describes API. Your task is to implement this REST API. You'll need to implement the routes and a controller. Declare the routes in `server/routes/api.php`.

When complete, you should have the following two API endpoints, which can be viewed in the Browser:

- `/api/people`
- `/api/people/{id}`

---

The application uses Webpack to compile our source files. Run `docker-compose run node` to start a shell session inside the `node` container. This container includes the required Node.js and Yarn versions. The remaining commands are expected to be run from this shell.

> Run `exit` to terminate the shell session and return to your host terminal.

Install the NPM dependencies and begin watching the client code for changes.

```
# yarn install
# yarn watch
```

Once Webpack finishes the initial compilation, open `http://localhost/ch2` in your Browser and continue with the instructions displayed onscreen.

---

After reviewing and comprehending the project structure, you'll be ready to begin building the application. If you have not done so already, open `http://localhost/ch2/design-templates` which provides UI that you are tasked with decomposing to build out the application; implementing all necessary components, actions, reducers, and selectors. Reference `chapter-2/linkedup-ux-guide.pdf` to understand the expected user flow and experiences.

At this point, a user should be able to see a list of people returned from our
API, Selecting a person should display that persons details, including an address or colleagues if available.

You're all done! Commit your changes and move onto `04-submission-cleanup.md`.
