import { NextComponentType, NextPageContext } from "next";
import { useRouter } from "next/router";
import Head from "next/head";
import { useQuery } from "react-query";

import Pagination from "../common/Pagination";
import { List } from "./List";
import { PagedCollection } from "../../types/collection";
import { Species } from "../../types/Species";
import { fetch, FetchResponse, parsePage } from "../../utils/dataAccess";
import { useMercure } from "../../utils/mercure";

export const getSpeciessPath = (page?: string | string[] | undefined) =>
  `/species${typeof page === "string" ? `?page=${page}` : ""}`;
export const getSpeciess = (page?: string | string[] | undefined) => async () =>
  await fetch<PagedCollection<Species>>(getSpeciessPath(page));
const getPagePath = (path: string) =>
  `/speciess/page/${parsePage("species", path)}`;

export const PageList: NextComponentType<NextPageContext> = () => {
  const {
    query: { page },
  } = useRouter();
  const { data: { data: speciess, hubURL } = { hubURL: null } } = useQuery<
    FetchResponse<PagedCollection<Species>> | undefined
  >(getSpeciessPath(page), getSpeciess(page));
  const collection = useMercure(speciess, hubURL);

  if (!collection || !collection["hydra:member"]) return null;

  return (
    <div>
      <div>
        <Head>
          <title>Species List</title>
        </Head>
      </div>
      <List speciess={collection["hydra:member"]} />
      <Pagination collection={collection} getPagePath={getPagePath} />
    </div>
  );
};
