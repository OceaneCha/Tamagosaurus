import { Item } from "./item";

export class Environment implements Item {
  public "@id"?: string;

  constructor(_id?: string, public name?: string, public species?: string) {
    this["@id"] = _id;
  }
}
