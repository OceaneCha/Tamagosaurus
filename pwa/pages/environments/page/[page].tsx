import { GetStaticPaths, GetStaticProps } from "next";
import { dehydrate, QueryClient } from "react-query";

import {
  PageList,
  getEnvironments,
  getEnvironmentsPath,
} from "../../../components/environment/PageList";
import { PagedCollection } from "../../../types/collection";
import { Environment } from "../../../types/Environment";
import { fetch, getCollectionPaths } from "../../../utils/dataAccess";

export const getStaticProps: GetStaticProps = async ({
  params: { page } = {},
}) => {
  const queryClient = new QueryClient();
  await queryClient.prefetchQuery(
    getEnvironmentsPath(page),
    getEnvironments(page)
  );

  return {
    props: {
      dehydratedState: dehydrate(queryClient),
    },
    revalidate: 1,
  };
};

export const getStaticPaths: GetStaticPaths = async () => {
  const response = await fetch<PagedCollection<Environment>>("/environments");
  const paths = await getCollectionPaths(
    response,
    "environments",
    "/environments/page/[page]"
  );

  return {
    paths,
    fallback: true,
  };
};

export default PageList;
