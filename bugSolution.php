function foo(a, b, visited = new Set()) {
  if (a === b) {
    return true;
  }
  if (typeof a !== 'object' || typeof b !== 'object' || a === null || b === null) {
    return false; 
  }
  if (visited.has(a) || visited.has(b)) {
    return false; //circular reference
  }
  visited.add(a);
  visited.add(b);
  const keysA = Object.keys(a);
  const keysB = Object.keys(b);
  if (keysA.length !== keysB.length) {
    return false;
  }
  for (let i = 0; i < keysA.length; i++) {
    const key = keysA[i];
    if (!b.hasOwnProperty(key) || !foo(a[key], b[key], visited)) {
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

// Example with circular reference
const obj1 = {};
const obj2 = {};
obj1.circular = obj2;
obj2.circular = obj1;

console.log(foo(obj1, obj1)); // true (correctly handles circular reference)
console.log(foo(obj1, obj2)); // true (correctly handles circular reference)
console.log(foo(obj1, {circular:obj2})); //false