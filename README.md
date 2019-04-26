
> A plugin to alter H5P.Text library to be abble to use it for unblock `Apuntes` Custom Post Type.

## Get Started

To start using this plugin you need to have installed docker and docker or generate .zip file for intallation with the following command!

```bash
$ ./scripts/build.sh (TODO)
```

Also you need to install [sherplay-h5p-library](https://github.com/dsuarezlogans/sherplay-h5p-library) for this to work. Go to the repo for instructions on how to install it.

## For Development

Before start hacking and runing the project you need to clone the [sherplay-h5p-library](https://github.com/dsuarezlogans/sherplay-h5p-library) repository at the same level of this repository to be able to link the modified `H5P.Text` library and add a `Text` interaction to unblock an `Apunte` Custom Post Type and have `Docker` installed in your machine.

Now you can easily start to work and interact with the plugin. To run the local wordpress server, simply run:

```bash
$ ./scripts/build.sh
```

Navigate to [http://localhost:8081](http://localhost:8081) to view your wordpress site with the already installed `sherplay-h5p-plugin`, you may need to install and activate the `H5P` plugin, also you need to install interactive video library.


#### Test video
    https://www.youtube.com/watch?v=A7ZkZazfvao