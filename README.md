
> A plugin to alter H5P.Text library to be able to use it for unblock `Classnote` Custom Post Type.

## Get Started

To start using this plugin download our last release [here](https://github.com/dsuarezlogans/sherplay-h5p-plugin/releases) and upload it to the `Add Plugin` section in your wordpress site.

Also make sure to install `H5P` plugin and [sherplay-h5p-library](https://github.com/dsuarezlogans/sherplay-h5p-library) for this to work. Go to the repo for instructions on how to install it.

## For Development

Before start hacking and runing the project you need to clone the [sherplay-h5p-library](https://github.com/dsuarezlogans/sherplay-h5p-library) repository at the same level of this repository to be able to link the modified `H5P.Text` library and add a `Text` interaction that have the ability to unblock a `Classnote` Custom Post Type. Also you need to have `Docker` and `docker-compose` installed in your machine.

Now you can easily start to work and interact with the plugin. To run the local wordpress server, simply run:

```bash
$ ./scripts/start.sh
```

Navigate to [http://localhost:8081](http://localhost:8081) to view your wordpress site with the already installed `sherplay-h5p-plugin` and them follow the steps below: 

- Install `H5P` plugin.
- Activate the `H5P` plugin.
- Install interactive video content type.

If you want to generate the `.zip` to install the plugin with your new changes in a separate wordpress site, just run:

```bash
$ ./scripts/build.sh
```

#### Test video
    https://www.youtube.com/watch?v=A7ZkZazfvao