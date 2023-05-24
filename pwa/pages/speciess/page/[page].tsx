import { GetStaticPaths, GetStaticProps } from "next";
import { dehydrate, QueryClient } from "react-query";

import {
  PageList,
  getSpeciess,
  getSpeciessPath,
} from "../../../components/species/PageList";
import { PagedCollection } from "../../../types/collection";
import { Species } from "../../../types/Species";
import { fetch, getCollectionPaths } from "../../../utils/dataAccess";

export const getStaticProps: GetStaticProps = async ({
  params: { page } = {},
}) => {
  const queryClient = new QueryClient();
  await queryClient.prefetchQuery(getSpeciessPath(page), getSpeciess(page));

  return {
    props: {
      dehydratedState: dehydrate(queryClient),
    },
    revalidate: 1,
  };
};

export const getStaticPaths: GetStaticPaths = async () => {
  const response = await fetch<PagedCollection<Species>>("/species");
  const paths = await getCollectionPaths(
    response,
    "species",
    "/speciess/page/[page]"
  );

  return {
    paths,
    fallback: true,
  };
};

export default PageList;
