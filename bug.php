function foo(a, b) {
  if (a === b) {
    return true;
  }
  if (typeof a !== 'object' || typeof b !== 'object') {
    return false; 
  }
  const keysA = Object.keys(a);
  const keysB = Object.keys(b);
  if (keysA.length !== keysB.length) {
    return false;
  }
  for (let i = 0; i < keysA.length; i++) {
    const key = keysA[i];
    if (!b.hasOwnProperty(key) || !foo(a[key], b[key])) {
      return false;
    }
  }
  return true;
}

console.log(foo({a:1, b:{c:3}}, {a:1, b:{c:3}})); // true
console.log(foo({a:1, b:{c:3}}, {a:1, b:{c:4}})); // false
console.log(foo({a:1, b:{c:3}}, {a:1, b:{c:3}, d:4})); //false
console.log(foo({a:1, b:[1,2,3]}, {a:1, b:[1,2,3]})); //true
console.log(foo(1,1)); //true
console.log(foo(1,2)); //false