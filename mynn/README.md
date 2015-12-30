# [MyANN]

MyANN is my (likely poor) attempt at implementing an [ANN](https://en.wikipedia.org/wiki/Artificial_neural_network)
library in PHP "from scratch". Not because I think existing codebases don't do the job, but rather just to try my
hand at it.

Don't download this expecting it to work - seriously, use [something else](http://php.net/manual/en/book.fann.php).

This code is nowhere near "production ready" - heck, I wouldn't even use it for a toy project. You've been warned...

## What's included

Within the download you'll find the following directories and files:

```
myann/
??? includes/
?   ??? layer.inc
?   ??? network.inc
?   ??? neuron.inc
?   ??? tfunction.inc
??? main.php
```

Each include file (*.inc) implements a class or a set of classes for one particular area of the ANN, with the
following (rough) hierarchy and definitions:

```
main.php - your code here (main.php is basically a testing platform right now)
?
?? network.inc - responsible for the overall network of neurons (as layers), plus forward and back-propagation
     ?
     ?? layer.inc - a single layer of neurons (mainly?)
          ?
          ?? neuron.inc - an individual neuron
               ?
               ?? tfunction.inc - threshold functions (binary, sigmoid, normal, bias)
```

## Bugs? Suggestions?

Yeah - this thing is in "flux" - it's no where near completed, and is probably buggy as hell. Again, don't expect much
from this code right now. If you have any suggestions, email me (if you want). Most of how I am coding this is from bits
out of my head (from past reading on ANNs, to what little I retained from ML Class and CS273), and stuff off the internet
(not code, but looking at diagrams and tutorials, to try to jog my head, etc).

I'm sure nothing I do here is anywhere near original - nor fast. Again, this is just a toy for me to play with, not
something serious.

## Contributing

I'm not taking any contributions currently, so don't bother with PR's or anything like that. But, feel free to fork and
play with it yourself! I take that back - don't look at this stuff; it will likely only teach you wrongly about ANNs!

## Versioning

What's that?

## Creators

**Andrew Ayers**

* <junkbotix.at.gmail.dot.org>
* <keeper63.at.cox.dot.net>

Currently, it's just me - and likely to stay that way...

## Copyright and license

Code and documentation copyright 2011-2015 Andrew L. Ayers. Code released under [the MIT license](https://opensource.org/licenses/MIT).
Docs released under [Creative Commons Attribution 4.0 International Public License](http://creativecommons.org/licenses/by/4.0/legalcode).

Subject to change in the future - but again, this isn't that likely.