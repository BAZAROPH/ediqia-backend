/*
Language: C
Category: common, system
Website: https://en.wikipedia.org/wiki/C_(programming_language)
Requires: c-like.js
*/

/** @type LanguageFn */
function c(hljs) {
  var lang = hljs.requireLanguage('c-like').rawDefinition();
  // Until C is actually different than C++ there is no reason to auto-detect C
  // as it's own language since it would just fail auto-detect testing or
  // simply match with C++.
  //
  // See further comments in c-like.js.

  // lang.disableAutodetect = false;
  lang.name = 'C';
  lang.aliases = ['c', 'h'];
  return lang;
}

module.exports = c;
