function getStorageValue (itemKey) {
  return window.sessionStorage.getItem(itemKey);
}

function setStorageValue (itemKey, value) {
  window.sessionStorage.setItem(itemKey, value);
}