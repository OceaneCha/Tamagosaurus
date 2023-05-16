import { NextComponentType, NextPageContext } from "next";
import { useRouter } from "next/router";
import Head from "next/head";
import { useQuery } from "react-query";

import Pagination from "../common/Pagination";
import { List } from "./List";
import { PagedCollection } from "../../types/collection";
import { Environment } from "../../types/Environment";
import { fetch, FetchResponse, parsePage } from "../../utils/dataAccess";
import { useMercure } from "../../utils/mercure";

export const getEnvironmentsPath = (page?: string | string[] | undefined) =>
  `/environments${typeof page === "string" ? `?page=${page}` : ""}`;
export const getEnvironments =
  (page?: string | string[] | undefined) => async () =>
    await fetch<PagedCollection<Environment>>(getEnvironmentsPath(page));
const getPagePath = (path: string) =>
  `/environments/page/${parsePage("environments", path)}`;

export const PageList: NextComponentType<NextPageContext> = () => {
  const {
    query: { page },
  } = useRouter();
  const { data: { data: environments, hubURL } = { hubURL: null } } = useQuery<
    FetchResponse<PagedCollection<Environment>> | undefined
  >(getEnvironmentsPath(page), getEnvironments(page));
  const collection = useMercure(environments, hubURL);

  if (!collection || !collection["hydra:member"]) return null;

  return (
    <div>
      <div>
        <Head>
          <title>Environment List</title>
        </Head>
      </div>
      <List environments={collection["hydra:member"]} />
      <Pagination collection={collection} getPagePath={getPagePath} />
    </div>
  );
};
