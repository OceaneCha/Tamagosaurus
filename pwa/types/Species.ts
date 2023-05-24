import { Item } from "./item";

export class Species implements Item {
  public "@id"?: string;

  constructor(
    _id?: string,
    public name?: string,
    public environment?: string[]
  ) {
    this["@id"] = _id;
  }
}
