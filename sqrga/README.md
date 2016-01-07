# SQR-GA - Square Root Genetic Algorithm

SQR-GA is an attempt to create a [genetic algorithm](https://en.wikipedia.org/wiki/Genetic_algorithm) in PHP to evolve
a code string as a solution for solving square roots. It does this by:

1. Generating an initial population of "actors" (the population of evolving entities) which have a randomly generated
code string.

2. Then, each member the population calculates (using the code string) what it thinks is the square root solution to a
randomly generated number.

3. Based on the solution, each entity is assigned a score.

4. The entities are sorted, lowest to highest scores (low scores are better in this simulation), and the first N
entities are used to form a "breeding population".

5. This "breeding population" is then subjected to a selected "breeding" algorithm, to create a new population (or
generation), with new code snippets.

6. Code execution continues in a cycle with step 2, until a given number of cycles (generations) is performed.

7. When done, the system outputs the information for the lowest scored actor (ie, the actor who calculated square
roots most correctly), along with an attempt to calculate the square roots for the numbers 1 through 100, and the code
string.

Breeding algorithms include:

1. Breed - two actors are selected to donate parts of their code for a "child"

2. Divide - a single actor's code is split into two parts, and then two "child" actors are created

3. Mutate - each actor in the population may be mutated, by one character in their code being changed

The code string consists of one or more of the characters "+", "-",  "*", "/", and "!". These characters are evaluated
as:

"+" = add one (1) to the answer

"-" = subract one (1) from the answer

"*" = multiply the answer by two (2)

"/" = divide the answer by two (2)

"!" = halt evaluation of code string (stop/end)

Scoring is based on how close to the correct answer a solution is for a given square root finding exercise, along with
the code string being the shortest to find roots.

This algorithm is meant as a toy for learning and experimentation, and does not reflect nor simulate any real biological
processes, outside of evolution with selection pressure, and basic "genetic mutation" to effect the individual and
population as a whole.

This code is not meant for any kind of "production use"...

## What's included

Within the download you'll find the following directories and files:

```
sqrga/
 |
 +-- actor.inc - actor entity class
 |
 +-- main.php - testing and experimentation wrapper
 |
 +-- sandbox.php - breeding environment setup and scoring
 ```

## Bugs? Suggestions?

Don't even bother suggesting any - this is mainly toy code meant for the user to have fun with; download it and modify
it however you see fit for your purposes. Above all, have fun with it!

## Contributing

I'm not taking any contributions currently, so don't bother with PR's or anything like that. But, feel free to fork and
play with it yourself!

## Versioning

What's that?

## Creators

**Andrew Ayers**

* junkbotix.at.gmail.dot.org
* keeper63.at.cox.dot.net

Currently, it's just me - and likely to stay that way...

## Copyright and license

Code and documentation copyright 2011-2015 Andrew L. Ayers. Code released under [the MIT license](https://opensource.org/licenses/MIT).
Docs released under [Creative Commons Attribution 4.0 International Public License](http://creativecommons.org/licenses/by/4.0/legalcode).

Subject to change in the future - but again, that isn't likely.