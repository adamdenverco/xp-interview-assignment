Submission and Clean up
=======================

You've completed the assignment, well done! Now all that is left is to package
up your work and do some house keeping with Docker.

Remove the NPM and Composer directories from your project files which you installed during the assignment. Run the following to remove these directories:

```
rm -rf client/node_modules
rm -rf server/vendor
```

Package your files into a zip and send them to `careers@engrain.com`
along with the subject title of "Senior Full Stack Engineer Interview Assignment".

That's it! You'll be notified once we've received and reviewed your work.

---

## House Keeping

Run `docker-compose down -v` to stop and remove all the containers and volumes we created for the assignment.

Run `docker rmi $(docker images -q)` if you would like to remove all the Docker images either built or downloaded onto your machine; this will include the images from the assignment. If you have prior Docker images or other projects using Docker, you may not want to run this command.
