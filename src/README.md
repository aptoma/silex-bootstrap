src folder
=========

The `src` folder is where your custom developed PHP code lives.
It is so far undecided whether JavaScript source files should live here, too.

This folder contains two folders by default:

- App, for application specific code
- Aptoma, for generic code

In theory, stuff in the `Aptoma` folder should have no dependencies to stuff in
the `App` folder, and should be suited for extraction into separate components.
It's perfectly OK to subclass stuff from `Aptoma` in `App`, in order to provide
application specific functionality or defaults.

Any 3rd party libraries should be managed by Composer, and will end up in the
`../vendor` folder.
