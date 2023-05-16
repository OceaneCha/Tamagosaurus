import {
  GetStaticPaths,
  GetStaticProps,
  NextComponentType,
  NextPageContext,
} from "next";
import DefaultErrorPage from "next/error";
import Head from "next/head";
import { useRouter } from "next/router";
import { dehydrate, QueryClient, useQuery } from "react-query";

import { Form } from "../../../components/species/Form";
import { PagedCollection } from "../../../types/collection";
import { Species } from "../../../types/Species";
import { fetch, FetchResponse, getItemPaths } from "../../../utils/dataAccess";

const getSpecies = async (id: string | string[] | undefined) =>
  id ? await fetch<Species>(`/species/${id}`) : Promise.resolve(undefined);

const Page: NextComponentType<NextPageContext> = () => {
  const router = useRouter();
  const { id } = router.query;

  const { data: { data: species } = {} } = useQuery<
    FetchResponse<Species> | undefined
  >(["species", id], () => getSpecies(id));

  if (!species) {
    return <DefaultErrorPage statusCode={404} />;
  }

  return (
    <div>
      <div>
        <Head>
          <title>{species && `Edit Species ${species["@id"]}`}</title>
        </Head>
      </div>
      <Form species={species} />
    </div>
  );
};

export const getStaticProps: GetStaticProps = async ({
  params: { id } = {},
}) => {
  if (!id) throw new Error("id not in query param");
  const queryClient = new QueryClient();
  await queryClient.prefetchQuery(["species", id], () => getSpecies(id));

  return {
    props: {
      dehydratedState: dehydrate(queryClient),
    },
    revalidate: 1,
  };
};

export const getStaticPaths: GetStaticPaths = async () => {
  const response = await fetch<PagedCollection<Species>>("/species");
  const paths = await getItemPaths(response, "species", "/speciess/[id]/edit");

  return {
    paths,
    fallback: true,
  };
};

export default Page;
